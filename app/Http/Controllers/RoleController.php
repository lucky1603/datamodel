<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function index() {
        return view('auth.roleindex');
    }

    public function list() {
        return Role::all()->map(function($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'label' => $role->label,
            ];
        });
    }

    public function data($id) {
        $role = Role::find($id);
        return [
            'name' => $role->name,
            'label' => $role->label,
            'startRoute' => $role->start_route,
            'abilities' => $role->abilities->map(function($ability) {
                return $ability->id;
            })
        ];
    }

    public function store(Request $request) {
        $data = $request->post();
        
        $startRoute = "default";
        if(isset($data['startRoute']) && !in_array($data['startRoute'], ['null', 'undefined'])) {
            $startRoute = $data['startRoute'];
        }

        $role = Role::create([
            'name' => $data['name'],
            'label' => $data['label'],            
            'start_route' => $startRoute
        ]);

        $abilities = $data['abilities'];
        $role->abilities()->sync($abilities);
        
        return $role;
    }

    public function update(Request $request, int $id) {
        $role = Role::find($id);    
        $data = $request->post();

        $role->update([
            'name' => $data['name'],
            'label' => $data['label'],
            'start_route' => $data['startRoute']
        ]);

        $role->abilities()->sync($data['abilities']);

        return $role;
    }

    public function delete($id) {
        return Role::find($id)->delete();
    }
}
