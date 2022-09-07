<?php

namespace App\Mail;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangePassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->user->getRememberToken() == '') {
            $this->user->setRememberToken(Str::random(60));
            $this->user->save();
        }

        return $this->view('emails.change-password', ['user' => $this->user, 'token' => $this->user->getRememberToken()]);
    }
}
