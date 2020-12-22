<?php

namespace App\Http\Controllers\Auth;

use App\Business\Client;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Updates the user with the data from the form.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
        $client = $user->client();

        return redirect(route('clients.profile', $client->getId()));

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
     * Creates the new user based on the data entered in the form.
     *
     * @param Request $request
     * @param Client $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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

        $user->assignRole('client');
        $client = Client::find($clientId);
        $client->attachUser($user);

        return redirect(route('clients.profile', $client->getId()));

    }
}
