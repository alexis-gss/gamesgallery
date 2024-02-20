<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Rating>
 */
final class PictureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'      => fake()->uuid(),
            'label'     => "Picture",
            'game_id'   => Game::query()->where('published', true)->get()->random(),
            'published' => true,
        ];
    }
}
