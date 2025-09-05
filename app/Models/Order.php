<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'total_price',
        'orderable_id',
        'orderable_type',
        'status',
    ];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * orderable
     *
     * @return MorphTo
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * ticket
     *
     * @return HasOne
     */
    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    /**
     * booking
     *
     * @return HasOne
     */
    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }
    /**
     * booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(str()->random(4)) . '-' . strtoupper(uniqid());
        });
    }
}
