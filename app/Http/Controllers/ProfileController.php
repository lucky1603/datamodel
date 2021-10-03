<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeGroup;
use App\Business\BusinessModel;
use App\Business\Client;
use App\Business\Contract;
use App\Business\DemoDay;
use App\Business\Founder;
use App\Business\Preselection;
use App\Business\Profile;
use App\Business\Program;
use App\Business\Selection;
use App\Business\TeamMember;
use App\Business\Training;
use App\Http\Middleware\Authenticate;
use App\Mail\MeetingNotification;
use App\Mail\ProfileCreated;
use App\Mail\ProfileRejected;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Gets the collection of profiles.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() {
        $this->authorize('manage_client_profiles');
        $profiles = Profile::find();

        return view('profiles.index', ['profiles' => $profiles]);
    }


    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, $id)
    {
        $this->authorize('read_client_profile', $id);
        session(['usereditbackto' => route(Route::currentRouteName(), $id)]);

        if(auth()->user()->isAdmin()) {
            $request->session()->put('backroute', route('profiles.index'));
        } else {

            $this_profile = auth()->user()->profile();
            if($this_profile->getId() != $id) {
                abort(401);
            }

            $request->session()->put('backroute', route('home'));
        }

        $profile = new Profile(['instance_id' => $id]);
//        $situations = $profile->getSituations();
        return view('profiles.show', ['model' => $profile, /* 'situations' => $situations */]);
    }

    public function create() {

        $this->authorize('manage_client_profiles');

        $attributes = collect(Profile::getAttributesDefinition());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
            return $item->name == 'profile_status';
        });

        $action = route('profiles.store');
        return view('profiles.create', ['attributes' => $attributes, 'action' => $action]);
    }

    public function store(Request $request) {
        $data = $request->post();

        // If the client fills it set the status to 'interested'
        if(auth()->user()->isRole('client')) {
            $data['profile_status'] = 2;
        }
        // If the NTP operator fills it set the status to 'mapped'
        if(auth()->user()->isAdmin()) {
            $data['profile_status'] = 1;
        }

        $profile = new Profile($data);

        $user = User::where(['email' => $data['contact_email']])->first();

        if($user === null) {
            $user = User::create([
                'name' => $data['contact_person'],
                'email' => $data['contact_email'],
                'password' => Hash::make(Str::random(10)),
                'position' => "Zastupnik",
            ]);

            $user->setRememberToken(Str::random(60));
            $user->save();

            $user->assignRole('profile');
        }

        // Attach default user to the instance.
        $profile->attachUser($user);

        if($profile->getAttribute('profile_status')->getValue() == 1) {
            $profile->addSituationByData(__('Mapped'), []);
        } else {
            $profile->addSituationByData(__('Interest'), []);
        }

        // TODO - Send email to the user.
        $email = $profile->getAttribute('contact_email')->getValue();
        Mail::to($email)->send(new ProfileCreated($profile));

        return redirect(route('profiles.index'));

    }

    public function reports($id) {
        $profile = Profile::find($id);
        return view('profiles.reports', ['model' => $profile]);
    }

    public function trainings($id) {
        $profile = Profile::find($id);
        return view('profiles.trainings', ['model' => $profile]);
    }

    public function sessions($id) {
        $profile = Profile::find($id);
        return view('profiles.sessions', ['model' => $profile]);
    }

    public function testMail($profileId) {
        $profile = new Profile(['instance_id' => $profileId]);
        $email = $profile->getAttribute('contact_email')->getValue();
        Mail::to('sinisa.ristic@gmail.com')->send(new ProfileCreated($profile));
        return [
            'code' => 0,
            'message' => 'Mail sent!'
        ];
    }

    /**
     * Show program choices.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request, $id) {
        $profile = Profile::find($id);
        $this_profile = auth()->user()->profile();
        if($this_profile->getId() != $profile->getId()) {
            abort(401);
        }

        $program = $profile->getActiveProgram();
        if($program != null && $profile->getAttribute('profile_status')->getValue() == 3) {
            $programType = $program->getAttribute('program_type' )->getValue();
            $programName = $program->getAttribute('program_name')->getValue();
            $attributeGroups = $program->getAttributeGroups();
            $attributes = $program->getAttributes();


            return view('profiles.apply',
                [
                    'model' => $profile,
                    'programType' => $programType,
                    'programName' => $programName,
                    'attributeGroups' => $attributeGroups,
                    'attributes' => $attributes,
                    'instance_id' => $program->instance->id,
                    'founders' => $program->getFounders(),
                    'teamMembers' => $program->getTeamMembers()
                ]);
        }

        return view('profiles.profile', ['model' => $profile]);
    }

    /**
     * Shows the form for the application for a program.
     * @param $programType
     * @param $profileId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply($programType, $profileId) {
        $profile = Profile::find($profileId);
        $this_profile = auth()->user()->profile();
        if($this_profile->getId() != $profile->getId()) {
            abort(401);
        }

        $attributeData = Program::getAttributesDefinition($programType);

        $programName = "Ostalo";
        switch ($programType) {
            case Program::$INKUBACIJA_BITF:
                $programName = 'Inkubacija BITF';
                break;
            case Program::$RASTUCE_KOMPANIJE:
                $programName = 'RASTUCE KOMPANIJE';
                break;
            case Program::$RAISING_STARTS:
                $programName = 'RAISING STARTS';
                break;
            default:
                break;
        }

        return view('profiles.apply',
            [
                'programType' => $programType,
                'programName' => $programName,
                'attributeGroups' => $attributeData['attributeGroups'],
                'attributes' => $attributeData['attributes'],
                'model' => $profile
            ]);
    }

    /**
     * Creates the new program, based on the data entered.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveApplicationData(Request $request) {
        $data = $request->post();

        if($data['programType'] == Program::$INKUBACIJA_BITF) {
            $fileData = $this->addFileToData($request, 'resenje_fajl');
            if($fileData != null) {
                $data['resenje_fajl'] = $fileData;
            }

            $fileData = $this->addFileToData($request, 'founders_cv');
            if($fileData != null) {
                $data['founders_cv'] = $fileData;
            }
        } else if($data['programType'] == Program::$RAISING_STARTS) {

            // get the files
            $data['rstarts_logo'] = $this->getFilesFromRequest($request, 'rstarts_logo');
            $data['rstarts_files'] = $this->getFilesFromRequest($request, 'rstarts_files');
            $data['rstarts_financing_proof_files'] = $this->getFilesFromRequest($request, 'rstarts_financing_proof_files');
            $data['rstarts_dodatni_dokumenti'] = $this->getFilesFromRequest($request, 'rstarts_dodatni_dokumenti');
            $data['rstarts_founder_cvs'] = $this->getFilesFromRequest($request, 'rstarts_founder_cvs');

        }

        // Check if the program already exists and is attached to the profile.
        if(isset($data['instance_id'])) {
            // If the program exist, update its properties.
            $program = new Program(0, ['instance_id' => $data['instance_id']]);
            $program->setData($data);

        } else {
            // Create program.
            $programType = $data['programType'];
            $program = new Program($programType, $data);

            // Add it to the profile.
            $profile = new Profile(['instance_id' => $data['profile_id']]);
            $profile->addProgram($program);

            // Generate situation.
            $profile->addSituationByData(__('Applying') , [
                'program_type' => $programType,
                'program_name' => $program->getAttribute('program_name')->getValue()
            ]);

            // Update the profile status.
            $profile->setData(['profile_status' => 3]);
        }

        if($data['programType'] == Program::$RAISING_STARTS) {

            // get the team members
            $memberCount = count($data['memberName']);
            if( $memberCount > 0 && $data['memberName'][0] != null) {
                $membersData = [];
                for($i = 0; $i < $memberCount; $i++) {
                    $membersData[] = [
                        'team_member_name' => $data['memberName'][$i],
                        'team_education' => $data['memberEducation'][$i],
                        'team_role' => $data['memberRole'][$i],
                        'team_other_job' => $data['memberOtherJob'][$i]
                    ];
                }

                $program->updateTeamMembers($membersData);
            } else {
                $program->removeAllMembers();
            }

            // get the founders
            $founderCount = count($data['founderName']);
            if( $founderCount > 0 && $data['founderName'][0] != null) {
                $foundersData = [];
                for($i = 0; $i < $founderCount; $i++) {
                    $foundersData[] = [
                        'founder_name' => $data['founderName'][$i],
                        'founder_part' => $data['founderPart'][$i],
                    ];

                }

                $program->updateFounders($foundersData);
            } else {
                $program->removeAllFounders();
            }
        }

        return redirect(route('home'));

    }

    /**
     * Checks if the form is ready for sending.
     * @param $profileId
     * @return array|false|string
     */
    public function check($profileId) {
        $profile = new Profile(['instance_id' => $profileId]);
        if($profile->instance == null) {
            return [
                'code' => 0,
                'message' => `No profile with id = {$profileId}`
            ];
        }

        $program = $profile->getActiveProgram();
        if($program == null) {
            return [
                'code' => 0,
                'message' => `No active program yet.`
            ];
        }

        $mandatory_parameters = collect([]);
        $data = $program->getData();

        $programType = $program->getAttribute('program_type')->getValue();
        if($programType == 5 /* Inkubacija BITF */) {
            $group_parameters = AttributeGroup::get('ibitf_general')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

            $group_parameters = AttributeGroup::get('ibitf_responsible_person')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

            // Obavezan unos sa bar jednog osnivaca.
            $group_parameters = AttributeGroup::get('ibitf_founders')->attributes->filter(function($attribute, $key) {
                return $key < 3;
            })->map(function($attribute, $key) {
                return $attribute->name;
            });

            $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

            $group_parameters = AttributeGroup::get('ibitf_founding_enterprise')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

            $group_parameters = AttributeGroup::get('ibitf_general_2')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

            $group_parameters = AttributeGroup::get('ibitf_expenses')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

            $group_parameters = AttributeGroup::get('ibitf_generate_income')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

            foreach($mandatory_parameters as $parameterName) {
                if(!isset($data[$parameterName])
                    || (is_string($data[$parameterName]) && strlen($data[$parameterName]) == 0) ) {
                    $attribute = Attribute::where('name', $parameterName)->first();
                    return json_encode([
                        'code' => 0,
                        'message' => 'Niste uneli parametar ----- ['.$attribute->name.'] -> "'.$attribute->label.'"',
                    ]);
                }
            }

            // Check for the attachments.
            // APR
            if(!isset($data['resenje_apr_link']) && $data['resenje_fajl']['filelink'] == '') {
                return json_encode([
                    'code' => 0,
                    'message' => 'Nema podataka o APR registraciji'
                ]);
            }

            // Check for the cv's.
            if(!isset($data['linkedin_founders']) && $data['founders_cv']['filelink'] == '') {
                return json_encode([
                    'code' => 0,
                    'message' => 'Nema podataka o osnivacima'
                ]);
            }

        }

        $profile->addSituationByData(__('Application Sent'),
            [
                'program_type' => $program->getAttribute('program_type')->getValue(),
                'program_name' => $program->getAttribute('program_name')->getValue()
            ]);

        if($program->getAttribute('needs_preselection')->getValue() == true) {
            $profile->getAttribute('profile_status')->setValue(4);
            $profile->addSituationByData(__('Preselection needed'),
                [
                    'program_type' => $program->getAttribute('program_type')->getValue(),
                    'program_name' => $program->getAttribute('program_name')->getValue()
                ]);
            $program->addPreselection(new Preselection());
        } else {
            $profile->getAttribute('profile_status')->setValue(6); // Selection
        }

        return json_encode([
            'code' => 1,
            'message' => "Prijava uspešno popunjena i poslata! Sačekajte da budete preusmereni."
        ]);

    }

    /**
     * Evaluatie preselection process.
     * @param Request $request
     * @return array
     */
    public function evalPreselection(Request $request): array
    {
        $data = $request->post();

        if(!isset($data['profile'])) {
            return [
                'code' => 1,
                'message' => __('Wrong parameters')
            ];
        }

        $profileId = $data['profile'];
        $profile = Profile::find($profileId);
        if($profile == null) {
            return [
                'code' => 2,
                'message' => __('Profile doesn\'t exist'),
            ];
        }

        // Go to
        if($data['passed'] == 'true') {
            // Add situation (preselection result).
            $profile->addSituationByData(__('Preselection Done'), [
                'preselection_passed' => true
            ]);

            if($profile->getActiveProgram()->getValue('program_type') == Program::$RAISING_STARTS) {
                // Go to selection.
                $profile->setData(['profile_status' => 5]);

                // Add selection to profile.
                $profile->getActiveProgram()->addDemoDay(new DemoDay());
            } else {
                // Go to selection.
                $profile->setData(['profile_status' => 6]);

                // Add selection to profile.
                $profile->getActiveProgram()->addSelection(new Selection());
            }
        } else {
            // Add situation (preselection result).
            $profile->addSituationByData(__('Preselection Done'), [
                'preselection_passed' => false
            ]);

            // Set status 'rejected'
            $profile->setData(['profile_status' => 9]);

            // Send rejection email to the user.
            $email = $profile->getAttribute('contact_email')->getValue();
            Mail::to($email)->send(new ProfileRejected($profile));
        }

        return [
            'code' => 0,
            'message' => 'Success'
        ];

    }


    /**
     * Evaluatie selection.
     * @param Request $request
     * @return array
     */
    public function evalSelection(Request $request) {
        $data = $request->post();

        if(!isset($data['profile'])) {
            return [
                'code' => 1,
                'message' => __('Wrong parameters')
            ];
        }

        $profileId = $data['profile'];
        $profile = Profile::find($profileId);
        if($profile == null) {
            return [
                'code' => 2,
                'message' => __('Profile doesn\'t exist'),
            ];
        }

        if($data['passed'] == 'true') {
            // Add situation (selection result).
            $profile->addSituationByData(__('Selection Finished'), [
                'selection_passed' => true
            ]);

            if($profile->getActiveProgram()->getAttribute('needs_contract')->getValue() == true) {
                // Go to contract
                $profile->setData(['profile_status' => 7]);

                // Add contract to profile.
                $profile->getActiveProgram()->addContract(new Contract());

                // Add Situation
                $profile->addSituationByData(__('Contract Signing'), []);
            } else {
                // Go to acceptance.
                $profile->setData(['profile_status' => 8]);

                // Add situation.
                $profile->addSituationByData(__('Accepted for Program'), []);
            }

        } else {
            // Add situation (preselection result).
            $profile->addSituationByData(__('Selection Finished'), [
                'selection_passed' => false
            ]);

            // Set status 'rejected'
            $profile->setData(['profile_status' => 9]);

            // Send rejection email to the user.
            $email = $profile->getAttribute('contact_email')->getValue();
            Mail::to($email)->send(new ProfileRejected($profile));
        }

        return [
            'code' => 0,
            'message' => 'Success'
        ];
    }

    public function evalContract(Request $request) {
        $data = $request->post();
        $file = $request->file('contract_document');

        if(!isset($data['profile'])) {
            return json_encode([
                'code' => 1,
                'message' => __('Wrong parameters')
            ]);
        }

        $profileId = $data['profile'];
        $profile = Profile::find($profileId);
        if($profile == null) {
            return json_encode([
                'code' => 2,
                'message' => __('Profile doesn\'t exist'),
            ]);
        }

        $contract = $profile->getActiveProgram()->getContract();
        if($contract == null) {
            return json_encode([
                'code' => 3,
                'message' => 'There is no contract to update'
            ]);
        }

        $unhandled = $contract->getAttributes()->filter(function($attribute) use($data) {
             $attname = $attribute->name;
             if($attribute->type == 'file') {
                 if($attribute->getValue()['filelink'] == '')
                     return true;
             } else {
                 return ($attribute->getValue() == null || $attribute->getValue() === 0 || $attribute->getValue() == '') && $attribute->name != 'contract_subject';
             }

        })->map(function($attribute) {
            return $attribute->label;
        });


        if($unhandled != null && $unhandled->count() > 0) {
            return json_encode([
                'code' => 4,
                'message' => __('gui.contract-validation-error', [
                    'fieldname' => $contract->getAttribute('contract_subject')->label
                ]),
                'unhandled' => $unhandled
            ]);
        }

        // Add situation.
        $profile->addSituationByData(__('Contract Signed'), []);

        // Change status, move forward.
        $profile->getAttribute('profile_status')->setValue(8);

        return json_encode([
            'code' => 0,
            'message' => 'Success',
            'unhandled' => $unhandled
        ]);
    }

    /**
     * Notifies the client that he should come to sign the contract.
     * @param Request $request
     * @param $profileId
     * @return false|string
     */
    public function notifyContract(Request $request) {
        $data = $request->post();

        if(!isset($data['profile'])) {
            return json_encode([
                'code' => 1,
                'message' => __('Wrong parameters')
            ]);
        }

        $profileId = $data['profile'];
        $profile = Profile::find($profileId);
        if($profile == null) {
            return json_encode([
                'code' => 2,
                'message' => __('Profile doesn\'t exist'),
            ]);
        }

        $dateAttribute = $profile->getActiveProgram()->getContract()->getAttribute('signed_at');
        if($dateAttribute == null || $dateAttribute->getValue() == null) {
            return json_encode([
                'code' => 3,
                'message' => __('gui.CONTRACT-DATE-MISSING')
            ]);
        }

        if($profile->instance == null) {
            return json_encode([
                'code' => 4,
                'message' => __('gui.NoProfile', ['profileid' => $profileId ])
            ]);
        }

        $email = $profile->getAttribute('contact_email')->getValue();
        Mail::to($email)->send(new MeetingNotification($profile, MeetingNotification::$CONTRACT));

        $profile->addSituationByData(__('Contract Date Sent'), [
            "signed_at" => $dateAttribute->getValue()
        ]);

        return json_encode([
            'code' => 0,
            'message' => __('gui.MailSentSuccess', ['email' => $email])
        ]);

    }

    public function getTrainingCandidates() {
        $programs = Program::find();
        $candidates = $programs->filter(function($program) {
            $profile = $program->getProfile();
            if(($program->getValue('program_type') == Program::$RAISING_STARTS && $profile->getValue('profile_status') > 4) ||
                $profile->getValue('profile_status') == 8) {
                return true;
            }

            return false;
        })->map(function($program) {
            return new class ($program) {
                public $id;
                public $programType;
                public $programName;
                public $profile;

                public function __construct($program)
                {
                    $this->id = $program->getId();
                    $this->programType = $program->getValue('program_type');
                    $this->programName = $program->getValue('program_name');
                    $this->profile = $program->getProfile()->getValue('name');
                }
            };
        });

        return $candidates;
    }

    /**
     * Gets the file from the request and pack it to the recognizable form.
     * @param Request $request
     * @param $filename
     * @return array|null
     */
    private function addFileToData(Request $request, $filename): ?array
    {
        $file = $request->file($filename);
        if($file != null) {
            $originalFileName = $file->getClientOriginalName();
            $path = $file->store('documents');
            $path = asset($path);
            return [
                'filename' => $originalFileName,
                'filelink' => $path
            ];
        }

        return null;
    }

    /**
     * Gets multiple files form the single file parameter in request.
     * @param Request $request
     * @param $filename
     * @return array
     */
    private function getFilesFromRequest(Request $request, $filename) {
        if(!$request->hasFile($filename))
            return [
                'filelink' => '',
                'filename' => ''
            ];

        if(is_array($request->file($filename))) {
            $files = [];
            if($request->hasFile($filename)) {
                foreach($request->file($filename) as $file) {
                    $originalFileName = $file->getClientOriginalName();
                    $path = $file->store('documents');
                    $path = asset($path);
                    $files[] = [
                        'filelink' => $path,
                        'filename' => $originalFileName
                    ];
                }
            }

            return $files;
        }


        $file = $request->file($filename);
        $originalFileName = $file->getClientOriginalName();
        $path = $file->store('documents');
        $path = asset($path);
        return [
            'filelink' => $path,
            'filename' => $originalFileName
        ];

    }

}
