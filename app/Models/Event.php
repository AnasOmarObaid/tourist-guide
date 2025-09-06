<?php

namespace App\Models;

use App\Enums\EventDateStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'city_id',
        'title',
        'description',
        'start_at',
        'end_at',
        'venue',
        'organizer',
        'lat',
        'lng',
        'price',
        'status'
    ];

    /**
     * The attributes that are append to collection
     *
     * @var list<string>
     */
    protected $appends = [
        'image_url',
        'formatted_created_at',
        'formatted_end_at',
        'formatted_start_at',
        'event_date_status',
        'attendees_images'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    /**
     * getImage Attribute
     *
     * @return void
     */
    public function getImageUrlAttribute()
    {
        return asset($this->getImagePath());
    }

    /**
     * getFormattedCreatedAtAttribute
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->start_at->format('jS M - D - g:i A');
    }

    /**
     * getFormattedEndAtAttribute
     *
     * @return string
     */
    public function getFormattedEndAtAttribute(): string
    {
        return $this->end_at->format('jS M - D - g:i A');
    }

    /**
     * getFormattedStartAtAttribute
     *
     * @return string
     */
    public function getFormattedStartAtAttribute(): string
    {
        return $this->start_at->format('jS M - D - g:i A');
    }

    /**
     * getEventDateStatusAttribute
     *
     * @return EventDateStatus
     */
    public function getEventDateStatusAttribute(): EventDateStatus
    {
        if ($this->start_at && $this->start_at->isFuture())
            return EventDateStatus::UPCOMING;

        if ($this->end_at && $this->end_at->isPast())
            return EventDateStatus::EXPIRED;

        if (
            $this->start_at && $this->start_at->isPast() &&
            (!$this->end_at || $this->end_at->isFuture())
        )
            return EventDateStatus::ONGOING;

        return EventDateStatus::UNKNOWN;
    }

    /**
     * tags
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get the image associated with the user.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->latest();
    }

    /**
     * city
     *
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * orders
     *
     * @return MorphMany
     */
    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    /**
     * tickets
     *
     * @return HasManyThrough
     */
    public function tickets() : HasManyThrough
    {
        return $this->hasManyThrough(
            Ticket::class,
            Order::class,
            'orderable_id',
            'order_id',
            'id',
            'id'
        )->where('orders.orderable_type', Event::class);
    }

    /**
     * getAttendeesImagesAttribute
     *
     * @return array
     */
    public function getAttendeesImagesAttribute(): array
    {
        return $this->tickets()
            ->with('user')
            ->get()
            ->filter(fn($ticket) => $ticket->user !== null)
            ->map(fn($ticket) => $ticket->user->getImagePath())
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * hasImage
     *
     * @return bool
     */
    public function hasImage(): bool
    {
        return $this->image?->path ? true : false;
    }

    /**
     * getImagePath
     *
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->hasImage() ? 'storage/' . $this->image?->path : 'https://placehold.co/600x400/';
    }


    /**
     * A single filtering scope for all supported filters.
     *
     * Accepts array|Request with keys:
     * q, city_id, status, tags, price_min, price_max, start_at_from, start_at_to, end_at_from, end_at_to
     */
    public function scopeFilter(mixed $query, mixed $filters) : mixed
    {
        $filters = $filters instanceof \Illuminate\Http\Request ? $filters->all() : (array) $filters;
        $f = collect($filters);

        // Search by title
        $q = trim((string) ($f->get('q') ?? ''));
        if ($q !== '') {
            $query->where('title', 'like', '%' . $q . '%');
        }

        // City filter
        $cityId = $f->get('city_id');
        if ($cityId !== null && $cityId !== '') {
            $query->where('city_id', $cityId);
        }

        // Status filter (1 = active, 0 = cancelled)
        $status = $f->get('status');
        if ($status !== null && $status !== '') {
            $value = null;
            if ($status === '0' || $status === 0 || $status === false) { $value = 0; }
            if ($status === '1' || $status === 1 || $status === true) { $value = 1; }
            if ($value !== null) {
                $query->where('status', $value);
            }
        }

        // Tags filter (match ANY of the selected tags)
        $tagIds = collect($f->get('tags', []))
            ->filter(fn($v) => $v !== null && $v !== '')
            ->map(fn($v) => (int) $v)
            ->filter()
            ->unique()
            ->values();
        if ($tagIds->isNotEmpty()) {
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds->all());
            });
        }

        // Price range (clamped to 1..9999)
        $floor = 1; $ceil = 9999;
        $hasMin = ($f->get('price_min') !== null && $f->get('price_min') !== '');
        $hasMax = ($f->get('price_max') !== null && $f->get('price_max') !== '');
        if ($hasMin || $hasMax) {
            $min = $hasMin ? (int) $f->get('price_min') : $floor;
            $max = $hasMax ? (int) $f->get('price_max') : $ceil;
            if ($min > $max) { [$min, $max] = [$max, $min]; }
            $min = max($floor, $min);
            $max = min($ceil, $max);
            $query->whereBetween('price', [$min, $max]);
        }

        // Start date range
        $startFrom = $f->get('start_at_from');
        $startTo   = $f->get('start_at_to');
        if ($startFrom && $startTo) {
            $query->whereBetween('start_at', [$startFrom, $startTo]);
        } elseif ($startFrom) {
            $query->whereDate('start_at', '>=', $startFrom);
        } elseif ($startTo) {
            $query->whereDate('start_at', '<=', $startTo);
        }

        // End date range
        $endFrom = $f->get('end_at_from');
        $endTo   = $f->get('end_at_to');
        if ($endFrom && $endTo) {
            $query->whereBetween('end_at', [$endFrom, $endTo]);
        } elseif ($endFrom) {
            $query->whereDate('end_at', '>=', $endFrom);
        } elseif ($endTo) {
            $query->whereDate('end_at', '<=', $endTo);
        }

        return $query;
    }

    /**
     * booted
     *
     * @return void
     */
    public static function booted()
    {
        static::deleting(function ($event) {

            // delete the image from storage
            if ($event->hasImage()) {
                if (Storage::disk('public')->exists($event->image?->path)) {
                    Storage::delete($event->image?->path);
                }
                // delete the image from database
                $event->image->delete();
            }

            // delete the tags
            $event->tags()?->detach();

            // delete order and tickets
            foreach ($event?->orders as $order) {

                // delete ticket
                $order->ticket?->delete();

                // at last delete the order
                $order?->delete();
            }

        });
    }
}
