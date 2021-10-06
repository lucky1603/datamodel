<?php

namespace App\Mail;

use App\Business\Mentor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MentorCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $mentor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mentor $mentor)
    {
        $this->mentor = $mentor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mentorcreated')->with(['recipient' => $this->mentor->getValue('name')]);
    }
}
