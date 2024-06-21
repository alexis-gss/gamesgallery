<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Rank::factory(10)->make()->each(function (Rank $rankModel, int $key) {
            $rankModel->rank = $key + 1;
            $rankModel->saveQuietly();
        });
    }
}
