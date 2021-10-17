<?php

namespace App\Http\Controllers;

use App\Business\Profile;
use App\Business\RaisingStartsProgram;
use App\Mail\ProfileCreated;
use App\User;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AnonimousController extends Controller
{
    /**
     * Leads to the page for anonimous profile account creation.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createProfile() {
        $attributes = collect(Profile::getAttributesDefinition());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
            return $item->name == 'profile_status';
        });

        $action = route('storeProfileAnonimous');
        return view('profiles.create', ['attributes' => $attributes, 'action' => $action]);
    }

    public function createRaisingStarts() {
        $attributeData = RaisingStartsProgram::getAttributesDefinition();
        return view('anonimous.createRaisingStarts', ['attributes' => $attributeData['attributes']]);
    }

    public function storeRaisingStarts(Request $request) {
        $data = $request->post();
        var_dump($data);
        die();
    }

    /**
     * Creates the new unverified user account.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $data = $request->post();

        $data['profile_logo'] = Utils::getFilesFromRequest($request, 'profile_logo');
        $data['profile_background'] = Utils::getFilesFromRequest($request, 'profile_background');

        // Set as 'interested'.
        $data['profile_status'] = 2;

        $profile = new Profile($data);
        $user = User::where(['email' => $data['contact_email']])->first();

        if($user === null) {
            $user = User::create([
                'name' => $data['contact_person'],
                'email' => $data['contact_email'],
                'password' => Hash::make(Str::random(10)),
                'position' => "Zastupnik"
            ]);
            $user->setRememberToken(Str::random(60));
            $user->save();

            $user->assignRole('profile');
        }

        // Attach default user to the instance.
        $profile->attachUser($user);

        if($profile->getAttribute('profile_status')->getValue() == 1) {
            $profile->addSituationByData(__('Mapped'), []);
        } else {
            $profile->addSituationByData(__('Interest'), []);
        }

        // Send verification email to the user.
        $email = $profile->getAttribute('contact_email')->getValue();
        Mail::to($email)->send(new ProfileCreated($profile));

        // Go to confirmation page.
        $token = $user->getRememberToken();
        return redirect(route('user.notify', ['token' => $token]));

    }

    /**
     * Verification of user account.
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verify($token) {
        $user = User::where('remember_token', $token)->first();

        $user->setAttribute('email_verified_at', now());
        $user->save();

        return view('auth.changepassword')->with(
            ['token' => $token, 'email' => $user->getAttribute('email')]
        );
    }

    public function notifyUser($token) {
        $user = User::where('remember_token', $token)->first();
        if($user == null) {
            abort(401);
        }

        return view('anonimous.notify-user');
    }

    public function testUser($userId) {
        $user = User::find($userId);
        echo 'Name of the user is '.$user->name.'<br />';
        echo 'Token is '.$user->getRememberToken().'<br />';
        die();
    }
}
