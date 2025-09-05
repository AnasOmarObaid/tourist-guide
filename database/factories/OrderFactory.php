<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $event = Event::inRandomOrder()->first();
        $hotel = Hotel::inRandomOrder()->first();
        $user  = User::inRandomOrder()->first();

        $total = $event->price;

        return [
            'user_id'        => $user->id,
            'orderable_id'   => $this->faker->randomElement([$event->id, $hotel->id]),
            'orderable_type' => $this->faker->randomElement([Event::class, Hotel::class]),
            'total_price'    => $total,
            'status'         => $this->faker->randomElement(['pending', 'paid', 'canceled']),
        ];
    }
}
