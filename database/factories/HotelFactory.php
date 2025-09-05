<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id'   => City::inRandomOrder()->first()?->id ?? 1,
            'name'      => $this->faker->unique()->company . ' Hotel',
            'venue'     => $this->faker->address,
            'owner'     => $this->faker->name,
            'price_per_night'   => $this->faker->randomFloat(2, 50, 500),
            'rate'           => $this->faker->numberBetween(1, 5),
            'cover' => null,
            'description'    => $this->faker->paragraph(4),
            'lat'            => $this->faker->latitude,
            'lng'            => $this->faker->longitude,
            'status' => $this->faker->boolean(50),
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function ($hotel) {

            // create cover for hotel
            $folder = 'uploads/images/hotels/' . 'hotel_' . $hotel->id;
            $availableCover = null;
            if ($availableCover == null)
                $availableCover = Storage::disk('public')->files($folder);
            if (count($availableCover) > 0) {
                $key = array_rand($availableCover);
                $path = $availableCover[$key];
                $hotel->update(['cover' => $path]);
            }


            // create images for rooms in hotel
            static $availableFiles = null;

            if ($availableFiles == null)
                $availableFiles = Storage::disk('public')->files('uploads/images/hotels/' . 'hotel_' . $hotel->id . '/rooms');

            // Pick and remove a random image from the available files
            if (count($availableFiles) > 0) {
                foreach ($availableFiles as $file) {

                    $key = array_rand($availableFiles);
                    $path = $availableFiles[$key];

                    $hotel->images()->create([
                        'path' => $path,
                    ]);

                    unset($availableFiles[$key]);
                }
            }
        });
    }
}
