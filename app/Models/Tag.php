<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
        'name'
    ];

    /**
     * events
     *
     * @return MorphToMany
     */
    public function events() : MorphToMany
    {
        return $this->morphedByMany(Event::class, 'taggable');
    }
}
