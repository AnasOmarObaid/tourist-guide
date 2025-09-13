<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelShortCollection extends JsonResource
{
    public static User $user;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cover_url' => $this->cover_url,
            'name' => $this->name,
            'rate' => $this->rate,
            'city' => $this->city->name,
            'venue' => $this->venue,
            'price_per_night' => $this->price_per_night,
            'is_favorite' => $this->isFavoriteForUser(),
            'favoritable_type' => Hotel::class,
        ];
    }

     /**
     * Check if this event is favorited by the authenticated user
     *
     * @return bool
     */
    protected function isFavoriteForUser(): bool
    {
        if (!self::$user)
            return false;

        return $this->favorites()->where('user_id', self::$user->id)->exists();
    }
}
