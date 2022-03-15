<?php

namespace App\Http\Controllers;

use App\Ability;
use Illuminate\Http\Request;

class AbilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        if(!auth()->user()->isAdmin)
            return abort(401);

        $abilities = Ability::all();
        return view('abilities.index', ['abilities' => $abilities]);
    }

    public function create() {
        if(!auth()->user()->isAdmin)
            return abort(401);

        return view('abilities.create');
    }

    public function store() {
        if(!auth()->user()->isAdmin)
            return abort(401);
    }


}
