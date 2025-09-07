<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'city_id',
        'name',
        'venue',
        'owner',
        'price_per_night',
        'rate',
        'description',
        'cover',
        'lat',
        'lng',
        'status'
    ];

    /**
     * The attributes that are append to collection
     *
     * @var list<string>
     */
    protected $appends = [
        'cover_url',
        'formatted_created_at',
        'attendees_images'
    ];

    /**
     * getCoverAttribute
     *
     * @return void
     */
    public function getCoverUrlAttribute()
    {
        return asset($this->getCoverPath());
    }

    /**
     * getFormattedCreatedAtAttribute
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('jS M - D - g:i A');
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
     * services
     *
     * @return BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'hotel_service');
    }

    /**
     * Get the images associated with the hotels.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
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
     * bookings
     *
     * @return HasManyThrough
     */
    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(
            Booking::class,
            Order::class,
            'orderable_id',
            'order_id'
        )->where('orders.orderable_type', Hotel::class);
    }

    /**
     * getAttendeesImagesAttribute
     *
     * @return array
     */
    public function getAttendeesImagesAttribute(): array
    {
        return $this->bookings()
            ->with('user')
            ->get()
            ->filter(fn($booking) => $booking->user !== null)
            ->map(fn($booking) => $booking->user->getImagePath())
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * hasCover
     *
     * @return bool
     */
    public function hasCover(): bool
    {
        return $this?->cover ? true : false;
    }

    /**
     * hasImages
     *
     * @return bool
     */
    public function hasImages(): bool
    {
        return $this->images ? true : false;
    }

    /**
     * getImagePath
     *
     * @return string
     */
    public function getCoverPath(): string
    {
        return $this->hasCover() ? 'storage/' . $this->cover : 'https://placehold.co/600x400/';
    }

    /**
     * A single filtering scope using when()
     * Keys: q, city_ids[], service_ids[], statuses[], price_min, price_max
     */
    public function scopeFilter($query, $filters)
    {
        $filters = $filters instanceof \Illuminate\Http\Request ? $filters->all() : (array) $filters;
        $f = collect($filters);

        $q = trim((string) ($f->get('q') ?? ''));
        $cityIds = collect($f->get('city_ids', []))->map(fn($v) => (int) $v)->filter()->values()->all();
        $serviceIds = collect($f->get('service_ids', []))->map(fn($v) => (int) $v)->filter()->values()->all();
        $statuses = collect($f->get('statuses', []))
            ->map(function ($v) { return ($v === '1' || $v === 1 || $v === true || $v === 'true') ? 1 : (($v === '0' || $v === 0 || $v === false || $v === 'false') ? 0 : null); })
            ->filter(fn($v) => $v === 0 || $v === 1)
            ->unique()->values()->all();

        $floor = 1; $ceil = 9999;
        $hasMin = ($f->get('price_min') !== null && $f->get('price_min') !== '');
        $hasMax = ($f->get('price_max') !== null && $f->get('price_max') !== '');
        $dateFrom = $f->get('date_from');
        $dateTo = $f->get('date_to');

        return $query
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('owner', 'like', "%{$q}%")
                       ->orWhere('venue', 'like', "%{$q}%");
                });
            })
            ->when(!empty($cityIds), function ($qb) use ($cityIds) {
                $qb->whereIn('city_id', $cityIds);
            })
            ->when(!empty($serviceIds), function ($qb) use ($serviceIds) {
                $qb->whereHas('services', function ($qs) use ($serviceIds) {
                    $qs->whereIn('services.id', $serviceIds);
                });
            })
            ->when(!empty($statuses), function ($qb) use ($statuses) {
                $qb->whereIn('status', $statuses);
            })
            ->when($hasMin || $hasMax, function ($qb) use ($f, $floor, $ceil, $hasMin, $hasMax) {
                $min = $hasMin ? max($floor, (int) $f->get('price_min')) : $floor;
                $max = $hasMax ? min($ceil, (int) $f->get('price_max')) : $ceil;
                if ($min > $max) { [$min, $max] = [$max, $min]; }
                // Only apply filter if values are different from defaults
                if ($min > $floor || $max < $ceil) {
                    $qb->whereBetween('price_per_night', [$min, $max]);
                }
            })
            ->when($dateFrom && $dateTo, function ($qb) use ($dateFrom, $dateTo) {
                $qb->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when($dateFrom && !$dateTo, function ($qb) use ($dateFrom) {
                $qb->whereDate('created_at', '>=', $dateFrom);
            })
            ->when(!$dateFrom && $dateTo, function ($qb) use ($dateTo) {
                $qb->whereDate('created_at', '<=', $dateTo);
            });
    }

    public static function booted()
    {
        static::deleting(function ($hotel) {

            // delete the images from storage for rooms and covers
            if ($hotel->hasImages() or $hotel->hasCover()) {
                $dir = 'uploads/images/hotels/hotel_' . $hotel->id;
                if (Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->deleteDirectory($dir);
                }

                // delete the images from database via relationship
                $hotel->images()->delete();
            }

            // delete the tags
            $hotel->tags()?->detach();

            // delete services
            $hotel->services()?->detach();

            // delete orders and bookings
            foreach ($hotel->orders as $order) {
                // delete booking
                $order->booking?->delete();
                // delete order
                $order->delete();
            }
        });
    }
}
