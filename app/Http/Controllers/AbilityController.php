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
        return view('auth.abilityindex');
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

    public function list() {
        return Ability::all();
    }

    public function data($id) {
        $ability = Ability::find($id);
        return $ability->load('roles');
    }

}
