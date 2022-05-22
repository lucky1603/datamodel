<?php

namespace App\Http\Controllers;

use App\Business\Mentor;
use App\Business\Program;
use App\Business\ProgramFactory;
use App\Business\Session;
use App\Mail\MentorCreated;
use App\Mail\ProfileCreated;
use App\MentorReport;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

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
        $role = auth()->user()->roles()->first()->name;
        return view('mentors.profile', ['mentor' => $mentor, 'role' => $role]);
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

    public function filterAddPrograms(Request $request, $mentorId): Collection
    {
        $data = $request->post();
        $name = '';
        if(isset($data['name'])) {
            $name = $data['name'];
        }

        $mentor = Mentor::find($mentorId);
        $mentorPrograms = $mentor->getPrograms();
        $mentorProgramIds = $mentorPrograms->map(function($program) {
            return $program->getId();
        });

        return DB::table('program_caches')->select()->get()->filter(function($program) use($name, $mentorProgramIds) {
            $contained = $mentorProgramIds->contains($program->program_id);
            if($name != '') {
                return $program->program_status == -1 && !$contained && str_contains($program->profile_name, $name);
            }

            return $program->program_status == -1 && !$contained;
        })->map(function($program) {
            return [
                'value' => $program->program_id,
                'text' => $program->profile_name.' - '.$program->program_name
            ];
        });
    }

    public function storeProgram(Request $request) {
        $data = $request->post();

        $mentor = Mentor::find($data['mentorId']);
        if(is_array($data['program'])) {
            $programIds = $data['program'];
            foreach ($programIds as $programId) {
                $program = ProgramFactory::resolve($programId);
                $mentor->addProgram($program);

                // Add reports
                foreach ($program->instance->reports as $report) {
                    $due_date = $report->contract_check;
                    $name = $report->report_name;

                    MentorReport::create([
                        'mentor_id' => $mentor->getId(),
                        'program_id' => $program->getId(),
                        'name' => $name,
                        'due_date' => $due_date
                    ]);
                }
            }
        } else {
            $program = Program::find($data['program']);
            $mentor->addProgram( $program );
            // Add reports
            foreach ($program->instance->reports as $report) {
                $due_date = $report->contract_check;
                $name = $report->report_name;

                MentorReport::create([
                    'mentor_id' => $mentor->getId(),
                    'program_id' => $program->getId(),
                    'name' => $name,
                    'due_date' => $due_date
                ]);

            }

        }

        return redirect(route('mentors.profile', ['mentor' => $mentor->getId()]));
    }

    public function deleteProgram($mentorId, $programId) {
        $mentor = Mentor::find($mentorId);
        $mentor->removeProgram(Program::find($programId));

        return redirect(route('mentors.profile', ['mentor' => $mentor->getId()]));
    }

    public function deleteAllPrograms($mentorId) {
        $mentor = Mentor::find($mentorId);
        $mentor->removeAllPrograms();

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
        $mentor = Mentor::find($mentorId);
        $token = csrf_token();
        return view('mentors.ownsessions', ['mentor' => $mentor, 'token' => $token]);
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
                if($attribute->getValue() != null && $attribute->getValue() != [ 'filelink' => '', 'filename' => '' ]) {
                    $data[$attribute->name] = [
                        'label' => $attribute->label,
                        'value' => $attribute->getValue()['filelink']
                    ];
                } else {
                    $data[$attribute->name] = [
                        'label' => $attribute->label,
                        'value' => asset('/images/custom/nophoto2.png')
                    ];
                }

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
            if($data['photo'] == null) {
                $data['photo'] = [
                    'filename' => 'nophoto2.png',
                    'filelink' => asset('/images/custom/nophoto2.png')
                ];
            }

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

    public function reportsForProgram($mentorId, $programId): array
    {
        $mentor = Mentor::find($mentorId);
        $reports = $mentor->getReportsForProgram($programId);
        $reportData = [];
        foreach($reports as $report) {
            $report->load('file_groups');
            $reportData[] = [
                'name' => $report->name,
                'dueDate' => date_format(date_create($report->due_date), 'd.m.Y.'),
                'id' => $report->id,
                'status' => $report->status,
            ];
        }

        return $reportData;
    }

}
