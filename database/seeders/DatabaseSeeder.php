<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // call other seeders
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            CitySeeder::class,
            EventSeeder::class,
            ServiceSeeder::class,
            HotelSeeder::class,
            OrderSeeder::class,
            TagSeeder::class,

            EventTagSeeder::class,
            EventOrderSeeder::class,
            HotelTagSeeder::class,
            HotelServiceSeeder::class,
            HotelOrderSeeder::class,

            FavoriteSeeder::class,
        ]);

        $this->command->line('');
    }
}
