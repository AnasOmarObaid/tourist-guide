<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('  Create 35 event orders with tickets successfully!');

        //create order with tickets
        Order::all()
            ->each(function ($order) {
                if($order->orderable_type == Event::class)
                    Ticket::factory()->create(['order_id' => $order->id]);
            });
    }
}
