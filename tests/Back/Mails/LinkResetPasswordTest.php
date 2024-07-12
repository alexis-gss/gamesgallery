<?php

namespace Tests\Back\Mails;

use App\Mails\Auth\LinkResetPassword;
use Illuminate\Support\Str;
use stdClass;
use Tests\TestCase;

class LinkResetPasswordTest extends TestCase
{
    /** @return void */
    public function testMailLinkResetPassword(): void
    {
        $model        = new stdClass();
        $model->token = Str::random(32);
        $subject = new LinkResetPassword($model);
        $subject->assertHasSubject(sprintf('%s - %s', trans('auth.email_title_reset_password'), config('app.name')));
    }
}
