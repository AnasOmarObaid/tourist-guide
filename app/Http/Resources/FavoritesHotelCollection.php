<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoritesHotelCollection extends JsonResource
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
            'name' => $this->name,
            'city' => $this->city->name,
            'venue' => $this->venue,
            'price_per_night' => $this->price_per_night,
            'rate' => $this->rate,
            'cover_url' => $this->cover_url,
            'favoritable_type' => Event::class,
            'services' => $this->services->pluck('name'),
        ];
    }
}
