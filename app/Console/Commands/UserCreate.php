<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Console\Command;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User (Visitor or Admin)';

    /**
     * Create a new command instance.
     *
     * @return void
     * @ignore phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return integer
     */
    public function handle(): int
    {
        $user           = new User();
        $user->name     = $this->ask('Name ?', 'Visitor');
        $user->email    = $this->ask('Email ?', 'visitor@gmail.com');
        $user->password = $this->secret('What is the password ?');
        if ($this->confirm('Is the user an admin ?')) {
            $user->role = Role::admin();
        } else {
            $user->role = Role::visitor();
        }
        $user->saveOrFail();

        $this->info('User created.');

        return 0;
    }
}
