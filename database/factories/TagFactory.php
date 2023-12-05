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
    public function definition(): array
    {
        $name      = fake()->unique()->word;
        $published = fake()->boolean(75);
        return [
            'name'         => $name,
            'slug'         => Str::of($name)->slug(),
            'published'    => $published,
            'published_at' => ($published) ? now() : null,
        ];
    }
}
