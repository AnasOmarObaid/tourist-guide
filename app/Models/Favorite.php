<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable =
    [
        'user_id',
    ];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * favoritable
     *
     * @return void
     */
    public function favoritable()
    {
        return $this->morphTo(); //favoritable_id, favoritable_type
    }
}
