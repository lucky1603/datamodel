<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class EditUserController extends Controller
{
    public function edit($id) {
        $user = User::find($id);
        return view('auth.edituser', ['user' => $user]);
    }

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
}
