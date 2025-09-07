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
     * A single filtering scope using when() for all supported filters.
     * Keys: q (search: order_number, hotel name, user name)
     * statuses[] (multi: confirmed|pending|canceled)
     */
    // public function scopeFilter($query, $filters)
    // {
    //     $filters = $filters instanceof \Illuminate\Http\Request ? $filters->all() : (array) $filters;
    //     $f = collect($filters);

    //     $q = trim((string) ($f->get('q') ?? ''));
    //     $validStatuses = ['confirmed', 'pending', 'canceled'];
    //     $statuses = collect($f->get('statuses', []))
    //         ->map(fn($v) => strtolower((string) $v))
    //         ->filter(fn($v) => in_array($v, $validStatuses, true))
    //         ->unique()
    //         ->values()
    //         ->all();

    //     return $query
    //         ->when($q !== '', function ($qb) use ($q) {
    //             $qb->where(function ($qq) use ($q) {
    //                 $qq->whereHas('order', function ($qo) use ($q) {
    //                     $qo->where('order_number', 'like', "%{$q}%")
    //                        ->orWhereHas('user', function ($qu) use ($q) {
    //                            $qu->where('full_name', 'like', "%{$q}%");
    //                        });
    //                 })
    //                 ->orWhereHas('hotel', function ($qh) use ($q) {
    //                     $qh->where('name', 'like', "%{$q}%");
    //                 });
    //             });
    //         })
    //         ->when(!empty($statuses), function ($qb) use ($statuses) {
    //             $qb->whereIn('status', $statuses);
    //         });
    // }
}
