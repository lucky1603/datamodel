<?php

namespace App\Http\Controllers;

use App\Business\Client;
use App\Business\Profile;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UserEditRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        $clients = Client::all();

        return view('users.index', ['users' => $users, 'clients' => $clients]);
    }

    public function addadmin() {
        return view('users.addadmin');
    }

    public function store(AddUserRequest $request) {
        $data = $request->post();

        $photo = $request->file('photo');
        if($photo != null) {
            $originalFileName = $photo->getClientOriginalName();
            $path = $photo->store('documents');
            $path = asset($path);
            $data['photo'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'photo' => isset($data['photo']) ? $data['photo']['filelink'] : null,
            'position' => isset($data['position']) ? $data['position'] : null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user->assignRole(Role::find($data['role']));

        if($data['role'] == 3 /* PROFILE */) {
            $profile = Profile::find($data['profile']);
            if($profile != null) {
                $profile->attachUser($user);
            }
        }

        return [
            'code' => 0,
            'message' => 'Success!',
            'user' => $user
        ];
    }

    public function update(UserEditRequest $request, $userId) {
        $data = $request->post();

        $user = User::find($userId);
        if($user == null) {
            return [
                'code' => 1,
                'message' => 'Ne postoji korisnik sa tim ID-jem'
            ];
        }

        $photo = $request->file('photo');
        if($photo != null) {
            $originalFileName = $photo->getClientOriginalName();
            $path = $photo->store('documents');
            $path = asset($path);
            $data['photo'] = [
                'filename' => $originalFileName,
                'filelink' => $path,
            ];
        }

        $user->photo = isset($data['photo']) ? $data['photo']['filelink'] : null;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->position = $data['position'];
        $user->save();
        $user->refresh();

        $oldRole = $user->roles()->first()->id;
        if($oldRole != $data['role']) {
            $user->assignRole(Role::find($data['role']));
        }

        if($data['role'] == 3) {
            $profile = $user->profile();
            if($profile != null && $profile->getId() != $data['profile']) {
                $profile->removeUser($user);
                $newProfile = Profile::find($data['profile']);
                if($newProfile != null) {
                    $newProfile->attachUser($user);
                }
            }
        }

        return [
            'code' => 0,
            'message' => 'Success!',
            'user' => $user
        ];

    }

    public function adminadded(Request $request) {

    }

    public function getSessionValue($key) {
        $value = Session::get($key);
        if(isset($value)) {
            return $value;
        }

        return -11  ;
    }

    public function setSessionValues(Request $request) {
        $data = $request->post();

        foreach ($data as $key=>$value) {
            Session::put($key, $value);
        }

        return 0;
    }

}
