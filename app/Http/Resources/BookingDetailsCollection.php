<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingDetailsCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->booking->id,
            'hotel_cover_url' => $this->booking->hotel->cover_url,
            'hotel_name' => $this->booking->hotel->name,
            'hotel_city' => $this->booking->hotel->city->name,
            'hotel_venue' => $this->booking->hotel->venue,
            'booking_check_in' => $this->booking->formatted_check_in,
            'booking_check_out' => $this->booking->formatted_check_out,
            'order_price' => $this->total_price,
            'user_name' => $this->user->full_name,
            'order_created_at' => $this->formatted_created_at,
            'time' => $this->created_at->format('g:i A'),
            'barcode_image' => asset('storage/uploads/images/tickets/ticket.png'),
            'order_number' => $this->order_number,
        ];
    }
}
