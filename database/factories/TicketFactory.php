<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::where('orderable_type', Event::class)->first();

        return [
            'order_id' => $order->id,
            'barcode'  => strtoupper(uniqid('TKT-')),
            'status'   => $this->faker->randomElement(['valid','used','canceled']),
        ];
    }
}
