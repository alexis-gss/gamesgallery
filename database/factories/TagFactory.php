<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Tag>
 */
final class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

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
            'name' => $name,
            'slug' => $published,
            'published' => $published,
            'published_at' => ($published) ? now() : null,
        ];
    }
}
