<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        Game::factory(30)->make()->each(function (Game $game) use (&$i) {
            $game->order = $i;
            $game->saveOrFail();
            $i = $i + 1;
        });

        // Seeder for taggables table.
        $tags = Tag::query()->get();
        Game::each(function (Game $model) use ($tags) {
            $offset = rand(0, 15);
            $length = rand(1, 2);
            $model->tags()->saveMany($tags->slice($offset, $length));
        });
    }
}
