<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketDetailsCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'event_image_url' => $this->ticket->event->image_url,
            'event_title' => $this->ticket->event->title,
            'event_start_at' => $this->ticket->event->formatted_start_at,
            'event_end_at' => $this->ticket->event->formatted_end_at,
            'event_city' => $this->ticket->event->city->name,
            'event_venue' => $this->ticket->event->venue,
            'user_name' => $this->user->full_name,
            'order_number' => $this->order_number,
            'order_created_at' => $this->formatted_created_at,
            'order_price' => $this->total_price,
            'time' => $this->created_at->format('g:i A'),
            'gate' => fake()->randomElement(['Yellow', 'Blue', 'Red', 'Orange']),
            'seat' => fake()->randomElement(['West B', 'West A', 'North A', 'North B']),
            'barcode_image' => asset('storage/uploads/images/tickets/ticket.png'),
            'barcode_number' => $this->ticket->barcode
        ];
    }
}
