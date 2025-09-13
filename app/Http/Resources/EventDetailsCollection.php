<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailsCollection extends JsonResource
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
            'image_url' => $this->image_url,
            'get_attendees_images_attribute' => $this->attendees_images,
            'attendees_count' => $this->tickets()->count('user_id'),
            'title' => $this->title,
            'start_at' => $this->formatted_start_at,
            'end_at' => $this->formatted_end_at,
            'venue' => $this->venue,
            'city' => $this->city->name,
            'organizer' => $this->organizer,
            'price' => $this->price,
            'event_status' => $this->event_date_status,
            'description' => $this->description,
            'is_favorite' => $this->isFavoriteForUser(),
            'favoritable_type' => Event::class,
        ];
    }


    /**
     * isFavoriteForUser
     *
     * @return bool
     */
    public function isFavoriteForUser() : bool
    {
        if(!self::$user)
            return false;

        return $this->favorites()->where('user_id', self::$user->id)->exists();
    }
}
