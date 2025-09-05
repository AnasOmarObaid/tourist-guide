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
    ];

    /**
     * getCoverUrlAttribute
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
