<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoritesEventCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'city' => $this->city->name,
            'venue' => $this->venue,
            'start_at' => $this->formatted_start_at,
            'end_at' => $this->formatted_end_at,
            'price' => $this->price,
            'event_status' => $this->event_date_status,
            'image_url' => $this->image_url,
            'favoritable_type' => Event::class,
            'get_attendees_images_attribute' => $this->attendees_images,
        ];
    }
}
