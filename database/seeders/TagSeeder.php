<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        Tag::factory(15)->make()->each(function (Tag $tag) use (&$i) {
            $tag->order = $i;
            $tag->saveOrFail();
            $i = $i + 1;
        });
    }
}
