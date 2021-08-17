<?php

namespace App\Http\Controllers;

use App\Business\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnonimousController extends Controller
{
    public function createProfile() {
        $attributes = collect(Profile::getAttributesDefinition());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
            return $item->name == 'profile_status';
        });

        $action = route('storeProfileAnonimous');
        return view('profiles.create', ['attributes' => $attributes, 'action' => $action]);
    }

    public function store(Request $request) {
        $data = $request->post();

        // Hash code the password.
        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Set as 'interested'.
        $data['profile_status'] = 2;

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
        return redirect(route('home'));

    }
}
