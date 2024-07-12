<?php

namespace Tests\Back\Commands;

use Tests\TestCase;

class MailTestTest extends TestCase
{
    /** @return void */
    public function testMailTest(): void
    {
        $this->artisan('mail:test')
            ->doesntExpectOutput()
            ->assertSuccessful();
    }
}
