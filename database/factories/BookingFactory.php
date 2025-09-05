<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::where('orderable_type', Hotel::class)->inRandomOrder()->first();

        return [
            'order_id'    => $order->id,
            'check_in'    => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'check_out'    => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'status'   => $this->faker->randomElement(['pending','confirmed','canceled']),
        ];
    }
}
