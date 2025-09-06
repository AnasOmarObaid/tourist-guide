<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'country',
        'description',
        'lat',
        'lng',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * The attributes that are append to collection
     *
     * @var list<string>
     */
    protected $appends = [
        'image_url',
    ];

    /**
     * getImageUrlAttribute
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
        return $this->created_at->format('jS M - D - g:i A');
    }

    /**
     * Get the image associated with the user.
    */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->latest();
    }


    /**
     * events
     *
     * @return HasMany
     */
    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * hotels
     *
     * @return HasMany
     */
    public function hotels() : HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    /**
     * hasImage
     *
     * @return mixed
     */
    public function hasImage() : mixed {

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
    protected static function booted()
    {
        static::deleting(function ($city) {
            // when delete the city remove the event
            foreach ($city?->events as $event) {
                $event?->delete();
            }

            // when delete the city also remove the hotels
            foreach($city?->hotels as $hotel){
                $hotel?->delete();
            }
        });
    }
}

