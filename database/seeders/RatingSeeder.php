<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Rating::factory(20)->make()->each(function (Rating $ratingModel, int $key) {
            $ratingModel->order = $key + 1;
            $ratingModel->saveQuietly();
        });
    }
}
