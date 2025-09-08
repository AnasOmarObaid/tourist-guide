<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class User extends Authenticatable

{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'phone',
        'address',
        'email',
        'password',
        'is_admin',
        'about_me',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the image associated with the user.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
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
    public function getImagePath() : string {

        // get the first Letters from full name -- Anas Omar ==> AO
        $initials = Str::of($this->full_name)->explode(' ')->map(fn($part) => $part[0])->join('');
        return $this->hasImage() ? 'storage/'. $this->image?->path : 'https://placehold.co/600x400/00695c/FFF/?font=raleway&text=' .  $initials;
    }


    /**
     * scopeIsAdmin
     *
     * @param  mixed $query
     * @param  bool $value
     * @return mixed
     */
    public function scopeIsAdmin(mixed $query, bool $value): mixed
    {
        return $query->where('is_admin', $value);
    }

    /**
     * orders (direct)
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * tickets via orders (only Event orders)
     *
     * @return HasManyThrough
     */
    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(
            Ticket::class,
            Order::class,
            'user_id',   // Foreign key on orders table...
            'order_id',  // Foreign key on tickets table...
            'id',        // Local key on users table...
            'id'         // Local key on orders table...
        )->where('orders.orderable_type', Event::class);
    }

    /**
     * bookings via orders (only Hotel orders)
     *
     * @return HasManyThrough
     */
    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(
            Booking::class,
            Order::class,
            'user_id',   // Foreign key on orders table...
            'order_id',  // Foreign key on bookings table...
            'id',        // Local key on users table...
            'id'         // Local key on orders table...
        )->where('orders.orderable_type', Hotel::class);
    }
}
