<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'code',
        'expires_at'
    ];

    /**
     * isExpired
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }
}
