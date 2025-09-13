<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EventShortCollection extends JsonResource
{
    public static User $user;

    /**
     * Static property to hold the authenticated user
     *
     * @var mixed
     */

    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'formatted_start_at' => $this->formatted_start_at,
            'image_url' => $this->image_url,
            'attendees_images' => $this->attendees_images,
            //'attendees_count' => $this->tickets()->distinct('user_id')->count('user_id'),
            'city_name' => $this->city?->name,
            'venue' => $this->venue,
            'is_favorite' => $this->isFavoriteForUser(),
            'favoritable_type' => Event::class,
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
