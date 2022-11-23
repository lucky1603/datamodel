<?php

namespace App\Mail;

use App\Business\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public Profile $profile;
    private $program;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        $this->program = $this->profile->getActiveProgram();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.application-success', ['profile' => $this->profile, 'program' => $this->program])->subject(__('Prijava je podneta'));
    }
}
