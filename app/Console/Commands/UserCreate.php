<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\Role;
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

        $this->order = null;
        $this->addOrder();

        $user = new User([
            'name' => $this->name,
            'slug' => str_slug($this->name),
            'email' => $this->email,
            'password' => $this->password,
            'picture' => asset(\config('images.default')),
            'role' => $this->role,
            'order' => $this->order
        ]);
        $user->saveOrFail();

        $this->info('User created.');

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
                    'name' => 'required|min:4,max:255'
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
                    [Role::admin()->label, Role::visitor()->label],
                    Role::visitor()->label,
                    $maxAttempts             = null,
                    $allowMultipleSelections = false
                );
                if ($tmp === Role::admin()->label) {
                    $tmp = Role::admin();
                }
                if ($tmp === Role::visitor()->label) {
                    $tmp = Role::visitor();
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

    /**
     * Add an order to the user.
     *
     * @return void
     */
    private function addOrder(): void
    {
        while (is_null($this->order)) {
            try {
                $maxOrder       = User::max('order');
                $this->order = $maxOrder + 1;
            } catch (ValidationException $e) {
                $this->error(sprintf('Can\t define an order, please try again later'));
                break;
            } //end try
        }; //end while
    }
}
