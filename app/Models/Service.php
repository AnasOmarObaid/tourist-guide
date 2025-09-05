<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
     use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * hotels
     *
     * @return BelongsToMany
     */
    public function hotels() : BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'hotel_service');
    }
}
