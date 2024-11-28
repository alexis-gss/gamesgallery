<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<\App\Models\Rank>
 */
final class RankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Game> $gamesUnrank */
        $gamesUnrank = Game::query()
            ->where('published', true)
            ->whereNotIn('id', DB::table('ranks')->pluck('game_id'))
            ->get();
        return [
            'game_id' => ($gamesUnrank->count())
                ? $gamesUnrank->random()->getKey()
                : Game::factory()->createQuietly(['published' => true]),
            'rank'    => 1,
        ];
    }
}
