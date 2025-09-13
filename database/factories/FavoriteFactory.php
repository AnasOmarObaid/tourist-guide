<?php
namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $types = [Hotel::class, Event::class];

        $tries = 0;
        do {
            $type = $this->faker->randomElement($types);

            $id = $type::inRandomOrder()->value('id');

            $exists = Favorite::where('user_id', $user->id)
                ->where('favoritable_id', $id)
                ->where('favoritable_type', $type)
                ->exists();

            $tries++;

            if ($tries > 15)
                break;

        } while ($exists);

        return [
            'user_id' => $user->id,
            'favoritable_id' => $id,
            'favoritable_type' => $type,
        ];
    }
}
