<?php

namespace App\Http\Controllers;

use App\Business\Client;
use Illuminate\Http\Request;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(auth()->user()->isAdmin() === false) {
            $instance = auth()->user()->instances->first();
            if(isset($instance) && $instance->entity->name === 'Client') {
                $client = Client::find($instance->id);
                return redirect(route('clients.profile', $client->getId()));
            } else {
                return redirect('/');
            }
        }

        return view('home');
    }
}
