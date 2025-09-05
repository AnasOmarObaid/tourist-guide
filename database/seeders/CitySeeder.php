<?php

namespace Database\Seeders;

use App\Models\City;
use App\Services\ImageService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('  Working on Cities!');

        $jeddah = City::create([
            'name' => 'Jeddah',
            'country' => 'Ksa',
            'description' => 'A major city in Saudi Arabia',
            'lat' => 21.2854,
            'lng' => 39.2376,
            'status' => true,
        ]);

        // upload image
        $jeddah->image()->create(['path' => 'uploads/images/cities/Jeddah.jpg',]);
        $this->command->line('  1. create Jeddah City');

        //******************************************************************************************
        $riyadh = City::create([
            'name' => 'Riyadh',
            'country' => 'Ksa',
            'description' => 'The capital city of Saudi Arabia',
            'lat' => 24.7136,
            'lng' => 46.6753,
            'status' => true,
        ]);

        // upload image
        $riyadh->image()->create(['path' => 'uploads/images/cities/Riyadh.jpg',]);
        $this->command->line('  2. create Riyadh City');

        //******************************************************************************************
        $dammam = City::create([
            'name' => 'Dammam',
            'country' => 'Ksa',
            'description' => 'A major city in the Eastern Province of Saudi Arabia',
            'lat' => 26.3927,
            'lng' => 49.9777,
            'status' => true,
        ]);

        // upload image
        $dammam->image()->create(['path' => 'uploads/images/cities/Dammam.jpg',]);
        $this->command->line('  3. create Dammam City');

        //******************************************************************************************
        $Khobar = City::create([
            'name' => 'Khobar',
            'country' => 'Ksa',
            'description' => 'A city in the Eastern Province of Saudi Arabia',
            'lat' => 26.2394,
            'lng' => 50.1971,
            'status' => true,
        ]);

        $Khobar->image()->create(['path' => 'uploads/images/cities/Khobar.jpg',]);
        $this->command->line('  4. create Khobar City');

        //******************************************************************************************
        $mecca = City::create([
            'name' => 'Mecca',
            'country' => 'Ksa',
            'description' => 'The holiest city in Islam',
            'lat' => 21.3891,
            'lng' => 39.8579,
            'status' => true,
        ]);

        $mecca->image()->create(['path' => 'uploads/images/cities/Mecca.jpg',]);
        $this->command->line('  5. create Mecca City');

        //******************************************************************************************
        $medina = City::create([
            'name' => 'Medina',
            'country' => 'Ksa',
            'description' => 'The second holiest city in Islam',
            'lat' => 24.4686,
            'lng' => 39.6142,
            'status' => true,
        ]);

        $medina->image()->create(['path' => 'uploads/images/cities/Medina.jpg',]);
        $this->command->line('  6. create Medina City');

    }
}
