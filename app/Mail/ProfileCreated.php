<?php

namespace App\Mail;

use App\Business\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfileCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $profile;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.profilecreated')
            ->with(['recipient' => $this->profile->getAttribute('contact_person')->getValue()])->subject(__("Profil je registrovan"));
    }
}
