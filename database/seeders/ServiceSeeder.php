<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('  Create services for hotel successfully!');

        $services = ['Free Wifi', 'Breakfast Included', 'Parking', 'Pool Access', 'Gym', 'Airport Shuttle'];

        foreach ($services as $service)
            Service::create(['name' => $service]);

    }
}
