<?php

namespace Tests\Back\Jobs;

use Tests\TestCase;

class DeleteUnassociatedPicturesTest extends TestCase
{
    /** @return void */
    public function testDeleteUnassociatedPictures(): void
    {
        $this->artisan('schedule:run')
            ->doesntExpectOutput()
            ->assertSuccessful();
    }
}
