<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('  Create tags for hotel successfully!');

         $allTags = Tag::all();

        // put tags for events
        Hotel::all()->each(function ($event) use ($allTags) {
            $event->tags()->sync(
                $allTags->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}
