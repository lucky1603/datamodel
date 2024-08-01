<?php

namespace App\Http\Controllers;

use App\Business\Client;
use App\Business\Mentor;
use App\Business\Profile;
use App\Business\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admin() {
        return view('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // if(auth()->user()->isAdmin() === false) {
        //     $instance = auth()->user()->instances->first();
        //     if(isset($instance) && $instance->entity->name === 'Profile') {
        //         $profile = Profile::find($instance->id);
        //         $program = $profile->getPrograms()->filter(function($program) {
        //             return $program->getStatus() == 1;
        //         })->first();

        //         if($program != null) {
        //             return redirect(route('programs.profile', ['program' => $program->getId()]));
        //         }

        //         return redirect(route('profiles.show', ['profile' => $profile->getId()]));

        //     }
        //     else if(isset($instance) && $instance->entity->name === 'Mentor') {
        //         $mentor = Mentor::find($instance->id);
        //         return redirect(route('mentors.profile', $mentor->getId()));
        //     }
        //     else {
        //         return redirect('/');
        //     }
        // }

        // return view('home');


        $user = auth()->user();
        $role = $user->role();
        switch($role->name) {
            case 'profile':
                $profile = $user->profile();
                if($profile != null) {
                    $program = $profile->getActiveProgram();
                    if($program != null) {
                        return redirect(route('programs.profile', ['program' => $program->getId()]));
                    }
                    return redirect(route('profiles.show', ['profile' => $profile->getId()]));
                }

                return abort(404);
                
            case 'mentor':
                $instance = $user->instances->filter(function($instance) {
                    return $instance->entity->name == 'Mentor';
                })->first();
                if($instance != null) {
                    $mentor = Mentor::find($instance->id);
                    return redirect(route('mentors.profile', $mentor->getId())); 
                } 

                return abort(404);

            default:
                return redirect(route($role->start_route));
        }
    }


}
