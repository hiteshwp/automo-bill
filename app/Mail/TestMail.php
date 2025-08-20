<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $body;

    public function __construct($subjectText, $body)
    {
        $this->subjectText = $subjectText;
        $this->body = $body;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->markdown('emails.test')
                    ->with([
                        'body' => $this->body,
                    ]);
    }
}
