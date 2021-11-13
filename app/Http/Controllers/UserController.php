<?php

namespace App\Http\Controllers;

use App\Business\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
