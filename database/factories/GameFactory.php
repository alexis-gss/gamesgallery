<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Game>
 */
final class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name      = $this->faker->unique()->word;
        $published = $this->faker->boolean(75);
        return [
            'folder_id' => $this->faker->randomElement(Folder::pluck('id')),
            'name' => $name,
            'slug' => Str::slug($name),
            'published' => $published,
            'published_at' => ($published) ? now() : null,
        ];
    }
}
