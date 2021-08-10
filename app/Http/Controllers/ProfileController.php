<?php

namespace App\Http\Controllers;

use App\Business\BusinessModel;
use App\Business\Client;
use App\Business\Profile;
use App\Business\Program;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Gets the collection of profiles.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() {
        $this->authorize('manage_client_profiles');
        $profiles = Profile::find();

        return view('profiles.index', ['profiles' => $profiles]);
    }


    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, $id)
    {
        $this->authorize('read_client_profile', $id);
        session(['usereditbackto' => route(Route::currentRouteName(), $id)]);

        if(auth()->user()->isAdmin()) {
            $request->session()->put('backroute', route('profiles.index'));
        } else {

            $this_profile = auth()->user()->profile();
            if($this_profile->getId() != $id) {
                abort(401);
            }

            $request->session()->put('backroute', route('home'));
        }

        $profile = new Profile(['instance_id' => $id]);
//        $situations = $profile->getSituations();
        return view('profiles.show', ['model' => $profile, /* 'situations' => $situations */]);
    }

    public function create() {
        $this->authorize('manage_client_profiles');

        $attributes = collect(Profile::getAttributesDefinition());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
            return $item->name == 'profile_status';
        });

        $action = route('profiles.store');
        return view('profiles.create', ['attributes' => $attributes, 'action' => $action]);
    }

    public function store(Request $request) {
        $data = $request->post();

        // Hash code the password.
        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // If the client fills it set the status to 'interested'
        if(auth()->user()->isRole('client')) {
            $data['profile_status'] = 2;
        }
        // If the NTP operator fills it set the status to 'mapped'
        if(auth()->user()->isAdmin()) {
            $data['profile_status'] = 1;
        }

        $profile = new Profile($data);

        if($profile != null) {
            $user = User::where(['email' => $data['contact_email']])->first();

            if($user === null) {
                $user = User::create([
                    'name' => $data['contact_person'],
                    'email' => $data['contact_email'],
                    'password' => $data['password'],
                    'position' => "Zastupnik"
                ]);

                $user->assignRole('profile');
            }

            // Attach default user to the instance.
            $profile->attachUser($user);

            if($profile->getAttribute('profile_status')->getValue() == 1) {
                $profile->addSituationByData(__('Mapped'), []);
            } else {
                $profile->addSituationByData(__('Interest'), []);
            }

        }

        // TODO - Send email to the user.
        return redirect(route('profiles.index'));

    }

    /**
     * Show program choices.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request, $id) {
        $profile = Profile::find($id);
        $this_profile = auth()->user()->profile();
        if($this_profile->getId() != $profile->getId()) {
            abort(401);
        }

        return view('profiles.profile', ['model' => $profile]);
    }

    /**
     * Shows the form for the application for a program.
     * @param $programType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply($programType, $profileId) {
        $profile = Profile::find($profileId);
        $this_profile = auth()->user()->profile();
        if($this_profile->getId() != $profile->getId()) {
            abort(401);
        }

        $attributeData = Program::getAttributesDefinition($programType);
        $programName = "Ostalo";
        switch ($programType) {
            case Program::$INKUBACIJA_BITF:
                $programName = 'Inkubacija BITF';
                break;
            case Program::$RASTUCE_KOMPANIJE:
                $programName = 'RASTUCE KOMPANIJE';
                break;
            case Program::$RAISING_STARTS:
                $programName = 'RAISING STARTS';
                break;
            default:
                break;
        }

        return view('profiles.apply',
            [
                'programType' => $programType,
                'programName' => $programName,
                'attributeGroups' => $attributeData['attributeGroups'],
                'attributes' => $attributeData['attributes'],
                'model' => $profile
            ]);
    }

    public function saveApplicationData(Request $request, Profile $profile) {

    }
}
