<?php

namespace App\Http\Controllers\Bo\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bo\Auth\LinkEmailRequest;
use App\Mails\Auth\LinkResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form when user forget his password.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLinkRequestForm(): \Illuminate\Contracts\View\View
    {
        return view('bo.auth.password.link-email');
    }

    /**
     * Store the token and send an email to the user.
     *
     * @param \App\Http\Requests\Bo\Auth\LinkEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(LinkEmailRequest $request): \Illuminate\Http\RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $fields = $request->validated();
            DB::table(config('auth.passwords.users.table'))->insert([
                'email'      => $fields['email'],
                'token'      => $fields['token'],
                'created_at' => Carbon::now()
            ]);

            Mail::to($fields['email'])->send(new LinkResetPassword((object)$fields));

            return redirect()->back()->with('success', trans('crud.other.reset_password_email'));
        });
    }
}
