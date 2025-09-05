<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Order;
use Illuminate\Database\Seeder;

class HotelOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('  Create booking for hotel successfully!');

        // create order with booking for this hotel
        Order::all()
        ->each(function ($order) {
                if($order->orderable_type == Hotel::class)
                    Booking::factory()->create(['order_id' => $order->id]);
            });
    }
}
