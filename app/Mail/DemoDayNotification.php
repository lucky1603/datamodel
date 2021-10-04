<?php

namespace App\Mail;

use App\Business\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoDayNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $profile;
    private $passed;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Profile $profile, $passed)
    {
        $this->profile = $profile;
        $this->passed = $passed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.demoday-notification', ['profile' => $this->profile, 'passed' => $this->passed]);
    }
}
