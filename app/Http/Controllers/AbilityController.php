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

    public function store(Request $request) {
        $data = $request->post();
        $ability = Ability::create([
            'name' => $data['name'],
            'label' => $data['label']
        ]);

        if(isset($data['roles'])) {
            $roles = $data['roles'];
            $ability->roles()->sync($roles);
        }
        
        
        return $ability;
    }

    public function update(Request $request, int $id) {
        $ability = Ability::find($id);
        $data = $request->post();

        if($ability != null) {
            $ability->update([
                'name' => $data['name'],
                'label' => $data['label']
            ]);

            $roles = $data['roles'];
            if(isset($roles)) {
                $ability->roles()->sunc($roles);
            }
        }

        return $ability;

    }

    public function delete($id) {
        return Ability::find($id)->delete();
    }


    public function list() {
        return Ability::all();
    }

    public function data($id) {
        $ability = Ability::find($id);
        return $ability->load('roles');
    }

}
