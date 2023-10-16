<?php

namespace Database\Factories;

use App\Models\Rank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Rank>
 */
final class RankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rank::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }
}
