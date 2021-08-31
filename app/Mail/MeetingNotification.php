<?php

namespace App\Mail;

use App\Business\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public static $PRESELECTION = 0;
    public static $SELECTION = 1;
    public static $CONTRACT = 2;

    private $profile;
    private $notification_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Profile $profile, $notification_type)
    {
        $this->profile = $profile;
        $this->notification_type = $notification_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification', ['profile' => $this->profile, 'type' => $this->notification_type]);
    }
}
