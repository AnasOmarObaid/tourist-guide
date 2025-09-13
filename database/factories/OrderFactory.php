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
        $user  = User::inRandomOrder()->first();

        $orderableType = $this->faker->randomElement([Event::class, Hotel::class]);
        $orderableId = $orderableType::inRandomOrder()->first()->id;

        return [
            'user_id'        => $user->id,
            'orderable_type' => $orderableType,
            'orderable_id'   => $orderableId,
            'total_price'    =>$this->faker->randomFloat(2, 50, 500),
            'status'         => $this->faker->randomElement(['pending', 'paid', 'canceled']),
        ];
    }
}
