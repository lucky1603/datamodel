<?php

namespace App\Http\Controllers\Auth;

use App\Business\Client;
use App\Business\Profile;
use App\Http\Controllers\Controller;
use App\Mail\ChangePassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EditUserController extends Controller
{
    /*
     * --------------------------------------------------------------
     * EditUserController
     * --------------------------------------------------------------
     * This controller handles the actions about the users that belong
     * to a client.
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'position' => ['required', 'string']
        ]);
    }

    public function changePassword(Request $request) {
        $userId = $request->post('user_id');
        $user = User::find($userId);
        $rememberToken = $user->getRememberToken();
        if($rememberToken == '') {
            $user->setRememberToken(Str::random(60));
            $user->save();
            $user->refresh();
            $rememberToken = $user->getRememberToken();
        }

        return view('auth.changepassword')->with(
            ['token' => $rememberToken, 'email' => $user->getAttribute('email')]
        );

    }



    /**
     * Calls the form for the editing of the client data.
     *
     * @param $id - Id of the user to be edited.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $user = User::find($id);
        return view('auth.edituser', ['user' => $user]);
    }

    public function userData($userId): array
    {
        $user = User::find($userId);
        return [
            'name' => $user->name,
            'photo' => $user->photo,
            'email' => $user->email,
            'position' => $user->position,
        ];
    }

    public function editFromAdminPreview($userId) {
        $user = User::find($userId);
        $backroute = session('usereditbackto');
        if(isset($backroute)) {
            return view('auth.edituser', ['user' => $user, 'backroute' => $backroute]);
        }

        return view('auth.edituser', ['user' => $user]);
    }

    /**
     * Updates the user with the data from the form.
     * @param Request $request
     * @param User $user
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user) {
        $data = $request->post();

        $photo = $request->file('photo');
        if($photo != null) {
            $originalFileName = $photo->getClientOriginalName();
            $path = $photo->store('documents');
            $path = asset($path);
            $user->photo = $path;
        }

        if(isset($data['name'])) {
            $user->name = $data['name'];
        }

        if(isset($data['email'])) {
            $user->email = $data['email'];
        }

        if(isset($data['position'])) {
            $user->position = $data['position'];
        }

        $user->save();

        if(Auth::user()->isAdmin()) {
            if(isset($data['backroute'])) {
                return redirect($data['backroute']);
            }

            return redirect(route('users'));
        }

//        $profile = $user->profile();
//        return redirect(route('profiles.profile', $profile->getId()));
        return [
            'code' => 0,
            'message' => "User changed!"
        ];

    }

    /**
     * Add the new user to the current client.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add() {
        $client = Auth::user()->client();
        return view('auth.adduser', ['client' => $client]);
    }

    /**
     *
     * Creates the new user based on the data entered in the formm
     *
     * @param Request $request
     * @param Client $clientId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function added(Request $request, $clientId) {
        $this->validator($request->all())->validate();
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
            'position' => isset($data['position']) ? $data['position'] : null,
            'photo' => isset($data['photo']) ? $data['photo']['filelink'] : null
        ]);

        $user->assignRole('profile');
        $profile = Profile::find($clientId);
        $profile->attachUser($user);

        return redirect(route('profiles.profile', $profile->getId()));

    }

    /**
     *
     * Prikaz svih korisnika sistema.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $users = User::all();
        $profiles = Profile::all();

        Session::remove('usereditbackto');

        return view('auth.userindex', ['users' => $users, 'profiles' => $profiles]);
    }

    /**
     *
     * Prikazi formu za dodavanje korisnika tipa 'administrator'
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addadmin() {
        return view('auth.addadmin');
    }

    /**
     * Dodaj korisnika tipa 'administrator' sa podacima unetim u formu.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function adminadded(Request $request) {
        $this->validator($request->all())->validate();
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
            'position' => isset($data['position']) ? $data['position'] : null,
            'photo' => isset($data['photo']) ? $data['photo']['filelink'] : null
        ]);

        $user->assignRole('administrator');

        return redirect(route('users'));
    }

    /**
     *
     * Otvori formu za dodavanje korisnika ya datog klijenta.
     *
     * @param $clientId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addForProfile($profileId) {
        $profile = Profile::find($profileId);
        $backroute = session('usereditbackto');
        if(isset($backroute)) {
            return view('auth.addforprofile', ['profile' => $profile, 'backroute' => $backroute]);
        }

        return view('auth.addforprofile', ['profile' => $profile]);
    }

    /**
     *
     * Dodaje korisnika za datog klijenta bazirano na podacima unesenih u formu.
     *
     * @param Request $request
     * @param $profileId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addedForProfile(Request $request, $profileId) {
        $this->validator($request->all())->validate();
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
            'position' => isset($data['position']) ? $data['position'] : null,
            'photo' => isset($data['photo']) ? $data['photo']['filelink'] : null
        ]);

        $user->assignRole('profile');
        $profile = Profile::find($profileId);
        $profile->attachUser($user);

        if(isset($data['backroute'])) {
            return redirect($data['backroute']);
        }

        return redirect(route('users'));
    }

    /**
     *
     * Poziva formu za brisanje.
     *
     * @param $userId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete($userId) {
        $user = User::find($userId);
        $return_to = route('users');
        return view('auth.deleteuser', ['user' => $user, 'return_to' => $return_to]);
    }

    /**
     *
     * Izvršava potvrđeno brisanje.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleted(Request $request) {

        $data = $request->post();

        if(isset($data['user_id'])) {
            $user = User::find(intval($data['user_id']));
            $user->delete();
        }

        $return_to = isset($data['return_to']) ? $data['return_to'] : route('users');
        return redirect($return_to);
    }

    public function deleteAsync(Request $request): array
    {
        $data = $request->post();

        if(isset($data['user_id'])) {
            $user = User::find(intval($data['user_id']));
            $user->delete();
            return [
                'code' => 0,
                'message' => 'Success! The user is deleted!'
            ];
        }

        return [
            'code' => 1,
            'message' => 'Error! No user with id = '.$data['user_id']
        ];
    }

    public function updatePassword(Request $request) {
        $request-> validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $data = $request->post();

        $user = User::where('remember_token', $data['token'])->first();
        $user->setAttribute("password", Hash::make($data['password']));
        $user->setRememberToken(null);
        $user->save();

        Auth::login($user);

        return redirect(route('home'));
    }

    public function initSendPassword(Request $request) {
        $userId = $request->post('user_id');
        $user = User::find($userId);
        if($user == null) {
            return 0;
        }

        Mail::to($user->email)->send(new ChangePassword($user));

        return 1;
    }

    public function changePasswordFromEmail($token) {
        $user = User::all()->filter(function($user) use($token) {
            return $user->getRememberToken() == $token;
        })->first();

        return view('auth.changepassword')->with(
            ['token' => $token, 'email' => $user->getAttribute('email')]
        );
    }


}
