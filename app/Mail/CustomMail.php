<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;
    public $message_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message_details)
    {
        //
        $this->message_details = $message_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->view('admin.mail.mail'); //->attach(public_path('pdf/sample.pdf'), ['as' => 'sample.pdf','mime' => 'application/pdf',]);
    }
}
