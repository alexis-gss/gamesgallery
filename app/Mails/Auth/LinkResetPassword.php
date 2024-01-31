<?php

namespace App\Mails\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LinkResetPassword extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var \stdClass
     */
    private \stdClass $data;

    /**
     * Create a new message instance.
     *
     * @param \stdClass $data
     * @return void
     */
    public function __construct(\stdClass $data)
    {
        $this->data = clone $data;
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
                trans('auth.email_title_reset_password'),
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
            markdown: 'back.emails.link-reset-password',
            with: ['data' => $this->data],
        );
    }
}
