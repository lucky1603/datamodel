<?php

namespace App\Http\Controllers;

use App\Business\Mentor;
use App\Business\Program;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $mentors = Mentor::find();
        return view('mentors.index', ['mentors' => $mentors]);
    }

    public function create() {
        $attributes = Mentor::getAttributesDefinition();
        $action = route('mentors.store');

        return view('mentors.create', ['attributes' => $attributes, 'action' => $action]);
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

        $mentor = new Mentor($data);

        return redirect(route('mentors.index'));

    }

    public function profile($mentorId) {
        $mentor = Mentor::find($mentorId);
        return view('mentors.profile', ['mentor' => $mentor]);
    }

    public function addProgram($mentorId) {
        $mentor = Mentor::find($mentorId);
        $allPrograms = Program::find();

        $mentorProgramIds = $mentor->getPrograms()->map(function($program) {
            return $program->getId();
        });

        $filteredPrograms = $allPrograms->filter(function($program) use ($mentorProgramIds) {
            if($mentorProgramIds->contains($program->getId()))
                return false;
            return true;
        });

        return view('mentors.addprogram', ['mentorId' => $mentorId, 'programs' => $filteredPrograms]);
    }

    public function storeProgram(Request $request) {
        $data = $request->post();

        $mentor = Mentor::find($data['mentorId']);
        if(is_array($data['program'])) {
            $programIds = $data['program'];
            foreach ($programIds as $programId) {
                $program = Program::find($programId);
                $mentor->addProgram($program);
            }
        } else {
            $program = Program::find($data['program']);
            $mentor->addProgram( $program );

        }


        return redirect(route('mentors.profile', ['mentor' => $mentor->getId()]));
    }

    public function deleteProgram($mentorId, $programId) {
        $mentor = Mentor::find($mentorId);
        $mentor->removeProgram(Program::find($programId));

        return redirect(route('mentors.profile', ['mentor' => $mentor->getId()]));
    }

}
