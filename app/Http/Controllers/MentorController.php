<?php

namespace App\Http\Controllers;

use App\Business\Mentor;
use App\Business\Program;
use App\Business\Session;
use App\Mail\MentorCreated;
use App\Mail\ProfileCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MentorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $mentors = Mentor::find();
        return view('mentors.index1', ['mentors' => $mentors]);
    }

    public function create() {
        $attributes = Mentor::getAttributesDefinition();
        $action = route('mentors.store');

        return view('mentors.create', ['attributes' => $attributes, 'action' => $action]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'specialities' => 'required',
            'mentor-type' => 'in:1,2'
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
        $user = User::where(['email' => $data['email']])->first();
        if($user == null) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(10)),
                'position' => "Mentor",
            ]);

            $user->setRememberToken(Str::random(60));
            $user->save();

            $user->assignRole('mentor');
        }

        $mentor->attachUser($user);

        // TODO - Send email to the user.
        $email = $mentor->getValue('email');
        Mail::to($email)->send(new MentorCreated($mentor));


        return redirect(route('mentors.index'));

    }

    public function edit($mentorId) {
        $mentor = Mentor::find($mentorId);
        $action = route('mentors.update');
        return view('mentors.edit2', ['mentor' => $mentor, 'action' => $action, 'attributes' => $mentor->getAttributes()]);
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'specialities' => 'required',
            'mentor-type' => 'in:1,2'
        ]);

        $data = $request->post();

        $photo = $request->file('photo');
        if($photo != null) {
            $originalFileName = $photo->getClientOriginalName();
            $path = $photo->store('documents');
            $path = asset($path);
            $data['photo'] = [
                'filename' => $originalFileName,
                'filelink' => $path
            ];
        }

        $mentorid = $data['mentorid'];
        unset($data['mentorid']);

        $mentor = Mentor::find($mentorid);
        $mentor->setData($data);

        return redirect(route('mentors.profile', ['mentor' => $mentorid]));
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

    /**
     * API call.
     * Gets the sessions table definition for the chosen program and mentor.
     * @param $programId
     * @param $mentorId
     * @return array[]
     */
    public function sessions($programId, $mentorId): array
    {
        $arr = [];

        $sessions = Session::find()->filter(function($session) use($programId, $mentorId) {
            if($session->getProgram()->getId() == $programId && $session->getMentor()->getId() == $mentorId) {
                return true;
            }

            return false;
        });

        foreach($sessions as $session) {
            $arr[] = new class($session) {
                public $id;
                public $title;
                public $date;
                public $hasfeedback;
                public $isFinished;
                public function __construct($session)
                {
                    $this->id = $session->getId();
                    $this->title = $session->getValue('session_title');
                    $this->date = $session->getValue('session_start_date');
                    $this->hasfeedback = $session->getText('has_mentor_feedback');
                    $this->isFinished = $session->getValue('session_is_finished');
                }
            };
        }

        $keys = [
            new class {
                public $key = 'title';
                public $label = 'Naslov';
            },
            new class {
                public $key = 'date';
                public $label = 'Datum';
            },
            new class {
                public $key = 'hasfeedback';
                public $label = 'Ima feedback';
            },
            new class {
                public $key = 'isFinished';
                public $label = 'Završena';
            }
        ];

        return [
            'keys' => $keys,
            'values' => $arr
        ];
    }

    public function ownSessions($mentorId) {
        return view('mentors.ownsessions', ['mentorId' => $mentorId]);
    }

    /**
     * API call.
     * Return programs table definition for the chosen mentor.
     * @param $mentorId
     * @return array[]
     */
    public function programs($mentorId): array
    {
        $mentor = Mentor::find($mentorId);
        $programs = $mentor->getPrograms();
        $values = [];
        foreach($programs as $program) {
            $values[] = new class($program) {
                public $id;
                public $profile;
                public $program;

                public function __construct($program)
                {
                    $this->id = $program->getId();
                    $this->profile = $program->getProfile()->getValue('name');
                    $this->program = $program->getValue('program_name');
                }
            };
        }

        $keys = [
            new class {
                public $key = 'profile';
                public $label = 'Profil';
            },
            new class {
                public $key = 'program';
                public $label = 'Program';
            }
        ];

        return [
            'keys' => $keys,
            'values' => $values,
        ];

    }

    public function showData($mentorId) {
        $mentor = Mentor::find($mentorId);
        $data = [];

        $order = ['name', 'company', 'email', 'phone', 'address', 'photo', 'specialities', 'mentor-type', 'remark'];

        foreach($order as $key) {
            $attribute = $mentor->getAttribute($key);
            if($attribute->name != 'photo') {
                $data[$attribute->name] = [
                    'label' => $attribute->label,
                    'value' => $attribute->getText()
                ];
            } else {
                $data[$attribute->name] = [
                    'label' => $attribute->label,
                    'value' => $attribute->getValue()['filelink']
                ];
            }

        }

        return json_encode($data);
    }

    public function forProgram($programId) {
        $program = Program::find($programId);
        $mentors = $program->getMentors()->map(function($mentor) {
            return new class($mentor) {
                public $id;
                public $photo;
                public $name;

                public function __construct($mentor)
                {
                    $this->id = $mentor->getId();
                    $this->photo = $mentor->getValue('photo')['filelink'];
                    $this->name = $mentor->getValue('name');
                    $this->address = $mentor->getValue('address');
                }
            } ;
        });
        $arr = [];
        foreach ($mentors as $mentor) {
            $arr[] = $mentor;
        }

        return $arr;
    }

    public function filter(Request $request): array
    {
        $data = $request->post();


        $filterData = [];
        if(isset($data) && count($data) > 0) {
            if($data['name'] != '') {
                $filterData['name'] = $data['name'];
            }

            if($data['mentorType'] != 0) {
                $filterData['mentor-type'] = $data['mentorType'];
            }
        }

        if(count($filterData) > 0) {
            $mentors = Mentor::find($filterData);
        } else {
            $mentors = Mentor::find();
        }


        $mentorList = [];
        foreach ($mentors as $mentor) {
            $data = $mentor->getData();
            $mentorList[] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'photo' => $data['photo'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'mentorType' => $data['mentor-type']
            ];
        }

        return $mentorList;
    }

}
