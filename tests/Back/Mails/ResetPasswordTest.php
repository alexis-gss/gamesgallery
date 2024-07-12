<?php

namespace Tests\Back\Mails;

use App\Mails\Auth\ResetPassword;
use App\Models\User;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /** @return void */
    public function testMailResetPassword(): void
    {
        $model   = User::factory()->createOneQuietly();
        $subject = new ResetPassword($model);
        $subject->assertHasSubject(sprintf('%s - %s', trans('auth.email_title_reset_complete'), config('app.name')));
    }
}
