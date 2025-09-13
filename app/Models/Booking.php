<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'check_in',
        'check_out',
        'total_price',
        'status'
    ];

    /**
     * The attributes that are append to collection
     *
     * @var list<string>
     */
    protected $appends = [
        'formatted_created_at',
        'formatted_check_in',
        'formatted_check_out'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'check_in' => 'datetime',
            'check_out' => 'datetime',
        ];
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
     * getFormattedCheckInAttribute
     *
     * @return string
     */
    public function getFormattedCheckInAttribute(): string
    {
        return $this->check_in->format('jS M - D - g:i A');
    }

    /**
     * getFormattedCheckOutAttribute
     *
     * @return string
     */
    public function getFormattedCheckOutAttribute(): string
    {
        return $this->check_out->format('jS M - D - g:i A');
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
     * hotel
     *
     * @return HasOneThrough
     */
    public function hotel(): HasOneThrough
    {
        return $this->hasOneThrough(
            Hotel::class,
            Order::class,
            'id',
            'id',
            'order_id',
            'orderable_id'
        )->where('orders.orderable_type', Hotel::class);
    }

    /**
     * Scope: current (still checked in)
     */
    public function scopeCurrent($query)
    {
        $now = now();
        return $query->where('check_in', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('check_out')
                    ->orWhere('check_out', '>=', $now);
            });
    }

    /**
     * Scope: past (already checked out)
     */
    public function scopePast($query)
    {
        $now = now();
        return $query->whereNotNull('check_out')
            ->where('check_out', '<', $now);
    }

}
