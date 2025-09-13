<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'user' => [
                'id' => $this->id,
                'image_url' => asset($this->getImagePath()),
                'full_name' => $this->full_name,
                'about_me' => $this->about_me,
                ],
            'favorites' => [
                'events' => FavoritesEventCollection::collection($this->favoriteEvents),
                'hotel' => FavoritesHotelCollection::collection($this->favoriteHotels),
            ],
        ];
    }
}

