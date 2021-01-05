<?php


namespace App\Http\Controllers;


use App\Business\Training;

class TrainingsController extends Controller
{
    public function index() {
        $trainings = Training::all();
        return view('trainings.index', ['trainings' => $trainings]);
    }

    public function create() {
        return view('trainings.create');
    }
}
