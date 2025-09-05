<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('  Create tags successfully!');

        $tags = ['Sports', 'Food', 'Music', 'Culture', 'Technology', 'Luxury', 'Budget', 'Family Friendly', 'Pet Friendly', 'Romantic'];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }

    }
}
