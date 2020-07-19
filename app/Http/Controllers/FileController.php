<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function create() {
        return view('files.create');
    }

    public function show(Request $request) {
        $file = $request->file('file');
        $realName = $file->getClientOriginalName();
        $path = $file->store('uploads');
        $path = asset($path);
        return view('files.show', ['filename' => $realName, 'filelink' => $path]);
    }
}
