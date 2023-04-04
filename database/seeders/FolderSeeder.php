<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        Folder::factory(10)->make()->each(function (Folder $folder) use (&$i) {
            $folder->order = $i;
            $folder->saveOrFail();
            $i = $i + 1;
        });
    }
}
