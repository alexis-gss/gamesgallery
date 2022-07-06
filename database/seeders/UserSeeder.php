<?php

namespace Database\Seeders;

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
        if (config('app.env') === 'local') {
            $user           = new User();
            $user->name     = 'Guts';
            $user->email    = 'berserk@gmail.com';
            $user->password = 'password';
            $user->role     = 0;
            $user->save();
        }

        $user           = new User();
        $user->name     = 'Alexis';
        $user->email    = 'alexis.gousseau@orange.fr';
        $user->password = 'password';
        $user->role     = 1;
        $user->save();
    }
}
