<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('  Create Services for hotel successfully!');

        $services = Service::all();
        Hotel::all()->each(function ($hotel) use ($services) {
            $hotel->services()->sync(
                $services->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}
