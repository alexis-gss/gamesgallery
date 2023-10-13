<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\Users\RoleEnum;
use App\Lib\Helpers\FileStorageHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Creates a new user
 */
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
    protected $description = 'Create user (Visitor or Admin)';

    /**
     * The name of the new user.
     *
     * @var string
     */
    protected $name;

    /**
     * The email of the new user.
     *
     * @var string
     */
    protected $email;

    /**
     * The password of the new user.
     *
     * @var string
     */
    protected $password;

    /**
     * The role of the new user.
     *
     * @var string
     */
    protected $role;

    /**
     * Execute the console command.
     *
     * @return integer
     */
    public function handle()
    {
        $this->name = null;
        $this->addName();

        $this->email = null;
        $this->addEmail();

        $this->password = null;
        $this->addPassword();

        $this->role = null;
        $this->addRole();

        $user                = new User();
        $user->name          = $this->name;
        $user->slug          = str_slug($this->name);
        $user->email         = $this->email;
        $user->password      = $this->password;
        $user->picture       = FileStorageHelper::storeFile(
            $user,
            new \SplFileInfo(\resource_path('../database/factories/assets/users/default-user-picture.png'))
        );
        $user->picture_alt   = "Default picture of a user profile";
        $user->picture_title = "User's picture of his profile";
        $user->role          = $this->role;
        $user->saveOrFail();

        $this->info('User created 👌');

        return 0;
    }

    /**
     * Add a name to the user.
     *
     * @return void
     */
    private function addName(): void
    {
        while (is_null($this->name)) {
            try {
                $tmp       = $this->ask('Type the wanted user name', 'Visitor');
                $validator = Validator::make(['name' => $tmp], [
                    'name' => 'required|min:3|max:255'
                ]);
                $validator->validate();
                $this->name = $tmp;
            } catch (ValidationException $e) {
                $this->error(sprintf(
                    'Please provide a valid name %s',
                    \implode(',', collect($e->errors())->flatten()->all())
                ));
                continue;
            } //end try
        }; //end while
    }

    /**
     * Add an email to the user.
     *
     * @return void
     */
    private function addEmail(): void
    {
        while (is_null($this->email)) {
            try {
                $tmp       = $this->ask('Type the wanted user email', 'visitor@gmail.com');
                $validator = Validator::make(['email' => $tmp], [
                    'email' => 'required|unique:users,email|email:rfc,dns'
                ]);
                $validator->validate();
                $this->email = $tmp;
            } catch (ValidationException $e) {
                $this->error(sprintf(
                    'Please provide a valid email %s',
                    \implode(',', collect($e->errors())->flatten()->all())
                ));
                continue;
            } //end try
        }; //end while
    }

    /**
     * Add a password to the user.
     *
     * @return void
     */
    private function addPassword(): void
    {
        while (
            ($this->password = $this->secret(
                (!\is_null($this->password) ? 'Failed to confirm, ' : '') . 'Type the wanted user password'
            )) !== $this->secret('Confirm the password')
        ) {
            continue;
        }; //end while
    }

    /**
     * Add a role to the user.
     *
     * @return void
     */
    private function addRole(): void
    {
        while (is_null($this->role)) {
            try {
                $tmp                         = $this->choice(
                    'Select his role',
                    [RoleEnum::admin()->label, RoleEnum::visitor()->label],
                    RoleEnum::visitor()->label,
                    $maxAttempts             = null,
                    $allowMultipleSelections = false
                );
                if ($tmp === RoleEnum::admin()->label) {
                    $tmp = RoleEnum::admin();
                }
                if ($tmp === RoleEnum::visitor()->label) {
                    $tmp = RoleEnum::visitor();
                }
                $validator = Validator::make(['role' => $tmp], [
                    'role' => 'required'
                ]);
                $validator->validate();
                $this->role = $tmp;
            } catch (ValidationException $e) {
                $this->error(sprintf(
                    'Please choose from the selection',
                    \implode(',', collect($e->errors())->flatten()->all())
                ));
                continue;
            } //end try
        }; //end while
    }
}
