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
                'desc' => $role->desc,
            ];
        });
    }

    public function data($id) {
        $role = Role::find($id);
        return [
            'name' => $role->name,
            'label' => $role->label,
            'abilities' => $role->abilities->map(function($ability) {
                return $ability->id;
            })
        ];
    }
}
