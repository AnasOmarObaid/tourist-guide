<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin =
            [
                'full_name' => 'Tourist Guide',
                'email' => 'admin@touristguide.com',
                'password' => Hash::make('admin@123456'),
                'phone' => '+966501234567',
                'address' => 'Jeddah King Abdulaziz Road',
                'is_admin' => true,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ];

        // create admin
        User::create($admin);

        $this->command->info('  Admin accounts created successfully!');
        $this->command->line('  1. admin@touristguide.com:admin@123456');
    }
}
