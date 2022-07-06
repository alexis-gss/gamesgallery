<?php

/**
 * Sender pour le contact
 * 
 * @category Description
 * @package  Category
 * @author   Name <email@email.com>
 * @license  http://url.com MIT
 * @link     http://url.com
 * phpcs:ignore PEAR.Commenting.FileComment.MissingVersion
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Undocumented class
 * 
 * @category Description
 * @package  Category
 * @author   Name <email@email.com>
 * @license  http://url.com MIT
 * @link     http://url.com
 */
class SendContactMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The form data.
     */
    protected $data;

    /**
     * The joined file name
     *
     * @var string
     */
    protected $joinedFileName;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $this->joinFileIfProvided();

        return $this->subject(
            "Contact - " . config('app.name', 'Prim\'s') . " - " . $data->topic)
            ->from($data->email)
            ->view('emails.send-contact', compact('data'));
    }

    /**
     * Attach a joined file if given in data
     *
     * @return void
     */
    protected function joinFileIfProvided(): void
    {
        if ($this->data->file) {
            $this->joinedFileName = sprintf(
                'Prims_MESSAGE-PJ-%s.%s',
                date("YmdHis"),
                $this->data->file->extension()
            );
            $this->attach(
                $this->data->file,
                [
                    'as' => $this->joinedFileName,
                    'mime' => $this->data->file->getMimeType()
                ]
            );
            $this->data->file = $this->joinedFileName;
        }
    }
}
