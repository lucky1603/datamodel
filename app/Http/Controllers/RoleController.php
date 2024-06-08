<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function list() {
        return Role::all()->map(function($role) {
            return [
                'id' => $role->id,
                'name' => $role->name
            ];
        });
    }
}
