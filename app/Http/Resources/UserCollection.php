<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
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
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
            'about_me' => $this->about_me,
            'image_url' => asset($this->getImagePath()),
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
