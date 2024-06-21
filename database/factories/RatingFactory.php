<?php

namespace Database\Factories;

use App\Models\Picture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Rating>
 */
final class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'picture_id' => fake()->randomElement(Picture::pluck('id'))
                ?? Picture::factory()->createQuietly(['published' => true]),
            'uuid'       => fake()->uuid(),
        ];
    }
}
