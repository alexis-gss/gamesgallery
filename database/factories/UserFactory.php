<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->word;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => $this->faker->unique()->email(),
            'picture_alt' => $this->faker->unique()->word,
            'picture_title' => $this->faker->unique()->word,
            'password' => $this->faker->password(),
            'role' => \collect(Role::toArray())->random()
        ];
    }
}
