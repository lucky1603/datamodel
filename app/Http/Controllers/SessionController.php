<?php

namespace App\Http\Controllers;

use App\Business\Mentor;
use App\Business\Profile;
use App\Business\Program;
use App\Business\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Get profile sessions.
     * @param $profileId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileSessions($profileId) {
        $profile = Profile::find($profileId);
        $sessions = $profile->getProgram()->getSessions();

        return view('profile.sessions', ['profile' => $profile, 'sessions' => $sessions ]);
    }

    /**
     * Create new session - show create form.
     * @param $programId
     * @param $mentorId
     * @return string
     */
    public function create($programId, $mentorId) {

        return view('sessions.create', ['programid' => $programId, 'mentorid' => $mentorId]);
    }

    public function store(Request $request) {
//        $request->validate([
//            'session_name' => 'required',
//            'session_start_date' => 'required|date',
//            'session_start_time' => 'required',
//        ]);

        $data = $request->post();
        foreach($data as $key=>$value) {
            echo 'data['.$key.'] = '.$value.'<br />';
        }

        $programId = $data['programid'];
        $mentorid = $data['mentorid'];


        unset($data['mentorid']);
        unset($data['programid']);

        $session = new Session($data);
        if($session->instance != null) {
            $program = Program::find($programId);
            $program->addSession($session);
            $mentor = Mentor::find($mentorid);
            $mentor->addSession($session);
        }

        return redirect(route('mentors.profile', ['mentor' => $mentorid]));
    }

    public function edit($sessionId) {
        $session = Session::find($sessionId);

        return view('sessions.edit', ['session' => $session]);
    }

    public function update(Request $request) {
        // TODO: Validation

        $data = $request->post();

        $sessionId = $data['sessionid'];
        $session = Session::find($sessionId);
        $profileId = $session->getProgram()->getProfile()->getId();
        $session->setData($data);

        return redirect(route('profiles.sessions', ['profile' => $profileId]));
    }

    public function show(Session $session) {
        return view('sessions.show', ['session' => $session]);
    }

    public function forMentor($mentorid) {

    }
}
