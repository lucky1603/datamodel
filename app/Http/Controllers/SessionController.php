<?php

namespace App\Http\Controllers;

use App\Business\Profile;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function profileSessions($profileId) {
        $profile = Profile::find($profileId);
        $sessions = $profile->getProgram()->getSessions();

        return view('profile.sessions', ['profile' => $profile, 'sessions' => $sessions ]);
    }
}
