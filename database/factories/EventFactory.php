<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => City::inRandomOrder()->first()?->id ?? 1,
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->text,
            'start_at' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'end_at' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'venue' => $this->faker->company . " Hall",
            'organizer' => $this->faker->name,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'price' => $this->faker->randomFloat(2, 10, 200),
            'status' => $this->faker->boolean(50),
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Event $event) {
            static $availableFiles = null;

            if ($availableFiles === null) {
                $availableFiles = Storage::disk('public')->files('uploads/images/events');
            }

            if (count($availableFiles) > 0) {
                // Pick and remove a random image from the available pool
                $key = array_rand($availableFiles);
                $path = $availableFiles[$key];
                unset($availableFiles[$key]);

                $event->image()->create([
                    'path' => $path,
                ]);
            }
        });
    }
}
