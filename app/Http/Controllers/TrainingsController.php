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
        var_dump($data);
        die();
    }
}
