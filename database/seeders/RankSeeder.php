<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Rank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rank::factory(10)->make()->each(function (Rank $rank, int $key) {
            $rank->rank    = $key + 1;
            $gamesUnrank   = Game::query()->whereNotIn('id', DB::table('ranks')->pluck('game_id'))->get();
            $rank->game_id = (count($gamesUnrank)) ? $gamesUnrank->random()->getKey() : null;
            $rank->saveOrFail();
        });
    }
}
