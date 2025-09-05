<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable =
    [
        'path'
    ];


    /**
     * Get the parent imageable model (user or hotel, etc...).
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
