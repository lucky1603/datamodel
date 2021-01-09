<?php


namespace App\Http\Controllers;


use App\Business\Training;
use Illuminate\Http\Request;

class TrainingsController extends Controller
{
    public function index() {
        $trainings = Training::all();
        return view('trainings.index', ['trainings' => $trainings]);
    }

    public function create() {
        return view('trainings.create');
    }

    public function store(Request $request) {

        $data = $request->post();
        $counter = 0;
        if($request->hasFile("attachment")) {
            foreach($request->file("attachment") as $file) {
                $data['file'.$counter++] = $file->getClientOriginalName();
            }
        }


        var_dump($data);

        die();
    }
}
