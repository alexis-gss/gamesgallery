<?php

namespace App\Mails\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var \App\Models\User $user
     */
    private User $user;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = clone $user;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new Envelope(
            subject: sprintf(
                '%s - %s',
                trans('auth.email_title_reset_complete'),
                config('app.name')
            ),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new Content(
            markdown: 'back.emails.reset-password',
            with: [
                'first_name' => $this->user->first_name,
                'last_name'  => $this->user->last_name,
            ],
        );
    }
}
