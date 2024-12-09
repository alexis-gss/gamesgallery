<?php

namespace Tests\Back\Commands;

use App\Enums\Users\RoleEnum;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /** @return void */
    public function testCreateUser(): void
    {
        $this->artisan('make:user')
            ->expectsQuestion('Type the wanted user first name', 'John')
            ->expectsQuestion('Type the wanted user last name', 'Doe')
            ->expectsQuestion('Type the wanted user email', 'john.doe@gmail.com')
            ->expectsQuestion('Type the wanted user password', 'password')
            ->expectsQuestion('Confirm the password', 'password')
            ->expectsQuestion('Select his role', \collect(RoleEnum::toArray())->random()->value)
            ->assertSuccessful();
    }
}
