<?php

namespace App\Http\Controllers;

use App\Business\Profile;
use Illuminate\Http\Request;

class AnonimousController extends Controller
{
    public function createProfile() {
        $attributes = collect(Profile::getAttributesDefinition());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
            return $item->name == 'profile_status';
        });

        $action = route('profiles.store');
        return view('profiles.create', ['attributes' => $attributes, 'action' => $action]);
    }
}
