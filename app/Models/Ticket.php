<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'barcode',
        'status'
    ];

    /**
     * The attributes that are append to collection
     *
     * @var list<string>
     */
    protected $appends = [
        'formatted_created_at',
    ];

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
     * order
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * user
     *
     * @return HasOneThrough
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Order::class,
            'id',
            'id',
            'order_id',
            'user_id'
        );
    }

    /**
     * event
     *
     * @return HasOneThrough
     */
    public function event(): HasOneThrough
    {
        return $this->hasOneThrough(
            Event::class,
            Order::class,
            'id',
            'id',
            'order_id',
            'orderable_id'
        )->where('orders.orderable_type', Event::class);
    }

    protected static function booted()
    {
        static::creating(function ($ticket) {
            // uniqid barcode
            $ticket->barcode = strtoupper(uniqid('TKT-'));
        });
    }
}
