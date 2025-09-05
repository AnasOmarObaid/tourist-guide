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
