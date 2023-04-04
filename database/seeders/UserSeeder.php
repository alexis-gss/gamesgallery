<?php

namespace Database\Seeders;

use App\Lib\Helpers\FileStorageHelper;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        User::factory(5)->make()->each(function (User $user) use (&$i) {
            $user->picture = FileStorageHelper::storeFile(
                $user,
                new \SplFileInfo(\resource_path('../database/factories/assets/users/default-user-picture.png'))
            );
            $user->order   = $i;
            $user->saveOrFail();
            $i = $i + 1;
        });
    }
}
