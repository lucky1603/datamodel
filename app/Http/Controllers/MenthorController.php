<?php

namespace App\Http\Controllers;

use App\Business\Menthor;
use Illuminate\Http\Request;

class MenthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $menthors = Menthor::find();
        return view('menthors.index', ['menthors' => $menthors]);
    }

    public function create() {
        $attributes = Menthor::getAttributesDefinition();
        $action = route('menthors.store');

        return view('menthors.create', ['attributes' => $attributes, 'action' => $action]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $data = $request->post();

        $file = $request->file('photo');
        if($file != null) {
            $originalFileName = $file->getClientOriginalName();
            $path = $file->store('documents');
            $path = asset($path);
            $data['photo'] = [
                'filename' => $originalFileName,
                'filelink' => $path
            ];
        }

        $menthor = new Menthor($data);

        return redirect(route('menthors.index'));


    }
}
