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
    public function run(): void
    {
        User::factory(5)->make()->each(function (User $userModel, int $key) {
            $userModel->picture = FileStorageHelper::storeFile(
                $userModel,
                new \SplFileInfo(\resource_path(
                    '../database/factories/assets/users/default-user-picture.png'
                ))
            );
            $userModel->order   = $key + 1;
            $userModel->saveQuietly();
        });
    }
}
