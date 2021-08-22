<?php

namespace App\Http\Controllers;

use App\Business\Client;
use App\User;
use Illuminate\Http\Request;

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

    public function adminadded(Request $request) {

    }

}
