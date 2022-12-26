<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeGroup;
use App\Business\IncubationProgram;
use App\Business\Profile;
use App\Business\Program;
use App\Business\ProgramFactory;
use App\Business\RaisingStartsProgram;
use App\Business\Situation;
use App\Business\Training;
use App\Http\Requests\UpdateIncubationRequest;
use App\Http\Requests\UpdateRaisingStartsRequest;
use App\Mail\ApplicationSuccess;
use App\ProfileCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ProgramController extends Controller
{

    public function index() {
        return view('programs.index');
    }

    public function create() {
        $profile = auth()->user()->profile();
        return view('programs.create', ['profile' => $profile]);
    }

    public function show($programId) {
        $this->authorize('read_program', $programId);
        $program = ProgramFactory::resolve($programId,true);
        return view('programs.show', ['program' => $program]);
    }

    public function profile($programId) {
        $this->authorize('read_program', $programId);
        $program = ProgramFactory::resolve($programId, true);
        $profile = $program->getProfile();
        if($program->getStatus() == 1) {
            $programType = $program->getValue('program_type');
            $programName = $program->getValue('program_name');
            $attributeGroups = $program->getAttributeGroups();
            $attributes = $program->getAttributes();

            return view('programs.apply',
                [
                    'model' => $profile,
                    'programType' => $programType,
                    'programName' => $programName,
                    'attributeGroups' => $attributeGroups,
                    'attributes' => $attributes,
                    'instance_id' => $program->instance->id,
                    'founders' => $program->getFounders(),
                    'teamMembers' => $program->getTeamMembers(),
                    'program' => $program
                ]);
        }

        return view('programs.profile', ['program' => $program]);
    }

    public function apply($programType, $profileId) {
        $profile = Profile::find($profileId);
        $this_profile = auth()->user()->profile();
        if($this_profile->getId() != $profile->getId()) {
            abort(401);
        }

        if($programType == Program::$RAISING_STARTS)
        {
            $attributeData = RaisingStartsProgram::getAttributesDefinition();
        } else {
            $attributeData = IncubationProgram::getAttributesDefinition();
        }

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

        return view('programs.apply',
            [
                'programType' => $programType,
                'programName' => $programName,
                'attributeGroups' => $attributeData['attributeGroups'],
                'attributes' => $attributeData['attributes'],
                'model' => $profile
            ]);
    }

    public function evalPhase(Request $request) {
        $data = $request->post();

        if(!isset($data['programId'])) {
            return [
                'code' => 1,
                'message' => __('Wrong parameters')
            ];
        }

        $programId = $data['programId'];
        $program = ProgramFactory::resolve($programId, true);
        if($program === null) {
            return [
                'code' => 2,
                'message' => __('Program doesn\'t exist'),
            ];
        }

        $profile = $program->getProfile();

        if($data['passed'] == 'on') {
            $validation = $program->getWorkflow()->getCurrentPhase()->validateData($data);
            if($validation['code'] != 0) {
                return $validation;
            }

            if($program->getWorkflow()->isLastStep())
            {
                // Set data.
                $program->getWorkflow()->getCurrentPhase()->setData($data);
                $program->setStatus(Program::$PROGRAM_ACTIVE);

                $situation = new Situation([
                    'name' => 'U PROGRAMU',
                    'description' => 'Klijent je počeo da koristi program',
                    'sender' => 'NTP'
                ]);

                $profile->addSituation($situation);
                $program->addSituation($situation);

                // Dodaj izveštaje
                $program->initReports();

            } else {
                $programStatus = $program->getStatus();
                $phase = $program->getWorkflow()->getCurrentPhase();
                $phase->setData($data);
                if($phase->requiresExitSituation()) {
                    $situation = $phase->getExitSituation();
                    if($situation != null) {
                        $profile->addSituation($situation);
                        $program->addSituation($situation);
                    }
                }

                if($phase->requiresExitEmail()) {
                    Mail::to($profile->getValue('contact_email'))->send($phase->getExitEmailTemplate());
                }

                $program->setStatus($programStatus + 1);
                $phase = $program->getWorkflow()->getCurrentPhase();
                if($phase->requiresEntrySituation()) {
                    $situation = $phase->getEntrySituation();
                    if($situation != null) {
                        $profile->addSituation($situation);
                        $program->addSituation($situation);
                    }

                }
                if($phase->requiresEntryEmail()) {
                    Mail::to($profile->getValue('contact_email'))->send($phase->getEntryEmailTemplate());
                }
            }
        } else {
            $program->setStatus(Program::$PROGRAM_SUSPENDED);
            $phase = $program->getWorkflow()->getCurrentPhase();
            $phase->setData($data);

            if($phase->requiresExitSituation()) {
                $profile->addSituation($phase->getExitSituation());
                $program->addSituation($phase->getExitSituation());
            } else {
                $situation = new Situation([
                    'name' => 'ODBIJEN',
                    'description' => 'Klijent je odbijen u fazi - "'.$phase->getDisplayName().'".',
                    'sender' => 'NTP'
                ]);
                $profile->addSituation($situation);
                $program->addSituation($situation);
            }

            if($phase->requiresExitEmail()) {
                Mail::to($profile->getValue('contact_email'))->send($phase->getExitEmailTemplate());
            }
        }

        // Update cache.
        DB::table('program_caches')
            ->where('program_id', $program->getId())
            ->update([
                'program_status' => $program->getStatus(),
                'program_status_text' => $program->getStatusText()
            ]);

        return [
            'code' => 0,
            'message' => __('Eval successfull!'),
        ];
    }

    public function check($programId) {

        $program = ProgramFactory::resolve($programId);
        if($program == null) {
            return json_encode([
                'code' => 0,
                'message' => `No active program yet.`
            ]);
        }

        $mandatory_parameters = collect([]);
        $data = $program->getData();

        $programType = $program->getAttribute('program_type')->getValue();

        if($programType == 5 /* Inkubacija BITF */) {
            $group_parameters = AttributeGroup::get('ibitf_general')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $abc = $group_parameters->filter(function($parameter) use($group_parameters, $program) {
                if($program->getValue('legal_status') != 2) {
                  return !in_array($parameter, ['pib', 'id_number', 'date_of_establishment','telephone_number','email']);
                } else {
                  return !in_array($parameter, ['telephone_number', 'email']);
                }
            });

            $mandatory_parameters = $mandatory_parameters->concat($abc);

            $group_parameters = AttributeGroup::get('ibitf_responsible_person')->attributes->map(function($attribute, $key) {
                return $attribute->name;
            });

            $abc = $group_parameters->filter(function($parameter) use($group_parameters, $program) {
                return !in_array($parameter, ['responsible_telephone', 'responsible_function']);
            });

            $mandatory_parameters = $mandatory_parameters->concat($abc);

            // // Obavezan unos sa bar jednog osnivaca. - Ovo je zakomentarisano jer se sada radi na drugi način.
            // $group_parameters = AttributeGroup::get('ibitf_founders')->attributes->filter(function($attribute, $key) {
            //     return $key < 3;
            // })->map(function($attribute, $key) {
            //     return $attribute->name;
            // });

            // $mandatory_parameters = $mandatory_parameters->concat($group_parameters);

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

            // Check for founders first
            if($program->getFounders()->count() == 0) {
                return json_encode([
                    'code' => 0,
                    'message' => 'Morate uneti bar jednog osnivača!',
                ]);
            }


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
            if(!isset($data['resenje_apr_link']) && (!isset($data['resenje_fajl']) || $data['resenje_fajl']['filelink'] == '')) {
                return json_encode([
                    'code' => 0,
                    'message' => 'Nema podataka o APR registraciji'
                ]);
            }

            // Check for the cv's.
            if(!isset($data['linkedin_founders']) &&(!isset($data['founders_cv']) || $data['founders_cv']['filelink'] == '')) {
                return json_encode([
                    'code' => 0,
                    'message' => 'Nema biografskih podataka o osnivacima'
                ]);
            }

        } else if($programType == Program::$RAISING_STARTS) {

            if(strtotime(now()) >= strtotime("2022-12-28 12:00:00"))
            {
                return json_encode([
                    'code' => 0,
                    'message' => 'Prošao je rok za slanje prijave!'
                ]);
            }

            $assertion = $this->checkRaisingStartsProgramData($program);
            if($assertion['code'] == 0) {
                return json_encode($assertion);
            }
        }

        $profile = $program->getProfile();
        $situation = $profile->addSituationByData(__('Application Sent'),
            [
                'program_type' => $program->getAttribute('program_type')->getValue(),
                'program_name' => $program->getAttribute('program_name')->getValue()
            ]);
        $program->addSituation($situation);
        $program->setStatus(2);
        DB::table('program_caches')->where('program_id', $program->getId())->update(
            [
                'program_status' => $program->getStatus(),
                'program_status_text' => $program->getStatusText()
            ]
        );

        // Send confirmation mail.
        $email = $profile->getValue('contact_email');
        try {
            Mail::to($email)->send(new ApplicationSuccess($profile));
        } catch (\Exception $e) {

        }

        return json_encode([
            'code' => 1,
            'message' => "Prijava uspešno popunjena i poslata! Sačekajte da budete preusmereni."
        ]);

    }

    public function backToForm(Request $request) {
        $programId = $request->post('program_id');
        $program = Program::find($programId);
        if($program != null) {
            $program->setStatus(1);
            DB::table('program_caches')->where('program_id', $program->getId())->update(
                [
                    'program_status' => $program->getStatus(),
                    'program_status_text' => $program->getStatusText()
                ]
            );


            $profile = $program->getProfile();
            if($profile != null) {
                $situation = new Situation([
                    'name' => 'VRACEN STATUS',
                    'description' => 'Vraćen je status kako bi klijent mogao da dopuni podatke.',
                    'sender' => 'NTP'
                ]);

                $profile->addSituation($situation);
                $program->addSituation($situation);
            }

            return [
                'code' => 0,
                'message' => 'Success!'
            ];
        }

        return [
            'code' => 1,
            'message' => __('Nema programa sa tim id-jem!')
        ];
    }

    private function checkRaisingStartsProgramData(RaisingStartsProgram $program): array
    {
        $data = $program->getData();

        if($data['rstarts_product_type'] == 0) {
            $attribute = $program->getAttribute('rstarts_product_type');
            return [
                'code' => 0,
                'message' => 'Nevalidna vrednost za parametar "'.$attribute->label.'"',
            ];
        }

        // Check for the team members.
        if($program->getTeamMembers()->count() < 2) {
            return [
                'code' => 0,
                'message' => 'Unesite bar 2 člana tima!',
            ];
        }

        // Checking for the founders.
        if($program->getFounders()->count() == 0) {
            return [
                'code' => 0,
                'message' => 'Mora postojati bar jedan osnivač!',
            ];
        }
        else {
            $founders = $program->getFounders();
            $total = 0.0;
            foreach($founders as $founder) {
                $total += $founder->getValue('founder_part');
            }

            if($total != 100.0) {
                return [
                    'code' => 0,
                    'message' => 'Suma osnivačkih procenata mora iznositi 100%!',
                ];
            }
        }

        if(!isset($data['rstarts_founder_cvs']) || count($data['rstarts_founder_cvs']) < 2){
            return [
                'code' => 0,
                'message' => 'Moraju se priložiti bar 2 datoteke za CV-jeve osnivača!',
            ];
        }

        // Texts.
        $texts = [
            'rstarts_team_history',
            'rstarts_app_motive',
            'rstarts_tagline',
            'rstarts_solve_problem',
            'rstarts_targetted_market',
            'rstarts_problem_solve',
            'rstarts_which_product',
            'rstarts_customer_problem_solve',
            'rstarts_benefits',
            'rstarts_how_innovative',
            'rstarts_clarification_innovative',
            'rstarts_dev_phase_tech',
            'rstarts_dev_phase_bussines',
            'rstarts_intellectual_property',
            'rstarts_research',
            'rstarts_innovative_area',
            'rstarts_business_plan',
            'rstarts_statup_progress',
            'rstarts_files',
            'rstarts_mentor_program_history',
            'rstarts_financing_sources',
            'rstarts_expectations',
            'rstarts_howmuchmoney',
            'rstarts_linkclip',
            'rstarts_howdiduhear',
        ];

        foreach($texts as $text) {
            if(!isset($data[$text])
                || ( is_array($data[$text]) && count($data[$text]) == 0)
                || (is_string($data[$text]) && strlen($data[$text]) == 0)
                || ($program->getAttribute($text)->type == 'select' && $data[$text] == 0)) {
                $attribute = Attribute::where('name', $text)->first();
                if($attribute == null) {
                    continue;
                }

                if($attribute->type != 'select') {
                    return [
                        'code' => 0,
                        'message' => 'Niste uneli parametar "'.$attribute->label.'"',
                    ];
                } else {
                    return [
                        'code' => 0,
                        'message' => 'Nevalidna vrednost za parametar "'.$attribute->label.'"',
                    ];
                }
            }
        }

        return [
            'code' => 1,
            'message' => 'Kontrola prošla uspešno!'
        ];
    }

    public function filterCache(Request $request) {
        $data = $request->post();

        $filter = [];
        if($data['name'] == '') {
            unset($data['name']);
            Session::forget('program_name');
        }
        else {
            Session::put('program_name', $data['name']);
            $name = $data['name'];
            unset($data['name']);
        }

        if($data['program_type'] == 0) {
            unset($data['program_type']);
            Session::forget('program_type');
        }
        else
            Session::put('program_type', $data['program_type']);

        if($data['program_status'] == 0) {
            unset($data['program_status']);
            Session::forget('program_status');
        } else {
            Session::put('program_status', $data['program_status']);
        }

        if($data['year'] == 0) {
            unset($data['year']);
            Session::forget('year');
        } else {
            Session::put('year', $data['year']);
        }

        if(count($data) == 0)
            $data = [];

        $query = count($data) ? DB::table('program_caches')->where($data) : DB::table('program_caches');
        if(isset($name)) {
            $query = $query->where('profile_name', 'like', $name.'%');
        }

        return $query->select()
            ->get()
            ->map(function($program) {
                return new class($program) {
                    public $id;
                    public $type;
                    public $typeText;
                    public $company;
                    public $logo;
                    public $status;
                    public $statusText;
                    public $year;

                    public function __construct($program)
                    {
                        $this->id = $program->program_id;
                        $this->type = $program->program_type;
                        $this->typeText = $program->program_type_text;
                        $this->company = $program->profile_name;
                        $this->logo = $program->profile_logo;
                        $this->status = $program->program_status;
                        $this->statusText = $program->program_status_text;
                        $this->year = $program->year;
                    }
                };
            });
    }

    public function saveIBITFApplicationData(UpdateIncubationRequest $request) {
        $data = $request->post();

        $fileData = $this->addFileToData($request, 'resenje_fajl');
        if($fileData != null) {
            $data['resenje_fajl'] = $fileData;
        }

        $fileData = $this->addFileToData($request, 'founders_cv');
        if($fileData != null) {
            $data['founders_cv'] = $fileData;
        }

        if(isset($data['instance_id'])) {
            // If the program exist, update its properties.
            $program = ProgramFactory::resolve($data['instance_id']);
            $program->setData($data);

        } else {
            // Create program.
            $data['init_workflow'] = true;

            // It will always be NTP Beograd.
            $data['ntp'] = 1;
            $program = ProgramFactory::create(Program::$INKUBACIJA_BITF, $data);

            // Add it to the profile.
            $profile = Profile::find($data['profile_id']);
            $profile->addProgram($program);

            // Generate situation.
            $situation = $profile->addSituationByData(__('Applying') , [
                'program_type' => Program::$INKUBACIJA_BITF,
                'program_name' => $program->getAttribute('program_name')->getValue()
            ]);

            $program->addSituation($situation);

            // Update the profile status.
            $profile->setData(['profile_status' => 2]);

            // Update cache
            DB::table('program_caches')
                ->insert([
                    'program_id' => $program->getId(),
                    'program_type' => $program->getValue('program_type'),
                    'program_type_text' => "INCUBATION BITF",
                    'profile_name' => $profile->getValue('name'),
                    'profile_logo' => $profile->getValue('profile_logo')['filelink'],
                    'program_status' => $program->getStatus(),
                    'program_status_text' => $program->getStatusText(),
                    'program_name' => $program->getValue('program_name'),
                    'ntp_text' => $program->getText('ntp'),
                    'year' => date('Y'),
                ]);
        }

        // get the founders
        $founderCount = count($data['founderName']);
        if( $founderCount > 0 && $data['founderName'][0] != null) {
            $foundersData = [];
            for($i = 0; $i < $founderCount; $i++) {
                $foundersData[] = [
                    'founder_name' => $data['founderName'][$i],
                    'founder_part' => $data['founderPart'][$i],
                    'founder_university' => $data['founderUniversity'][$i]
                ];

            }

            $program->updateFounders($foundersData);
        } else {
            $program->removeAllFounders();
        }

        return redirect(route('programs.profile', ['program' => $program->getId()]));
    }

    public function saveApplicationData(UpdateRaisingStartsRequest $request) {
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
            $files = Utils::getFilesFromRequest($request, 'rstarts_logo');
            if($files != null && $files != [ 'filelink' => '', 'filename' => '']) {
                $data['rstarts_logo'] = $files;
            }

            $files = Utils::getFilesFromRequest($request, 'rstarts_files');
            if($files != null && $files != [ 'filelink' => '', 'filename' => '']) {
                $data['rstarts_files'] = $files;
            }

            $files = Utils::getFilesFromRequest($request, 'rstarts_financing_proof_files');
            if($files != null && $files != [ 'filelink' => '', 'filename' => '']) {
                $data['rstarts_financing_proof_files'] = $files;
            }

            $files = Utils::getFilesFromRequest($request, 'rstarts_dodatni_dokumenti');
            if($files != null && $files != [ 'filelink' => '', 'filename' => '']) {
                $data['rstarts_dodatni_dokumenti'] = $files;
            }

            $files = Utils::getFilesFromRequest($request, 'rstarts_founder_cvs');
            if($files != null && $files != [ 'filelink' => '', 'filename' => '']) {
                $data['rstarts_founder_cvs'] = $files;
            }

        }

        // Check if the program already exists and is attached to the profile.
        if(isset($data['instance_id'])) {
            // If the program exist, update its properties.
            $program = ProgramFactory::resolve($data['instance_id']);
            $program->setData($data);

        } else {
            // Create program.
            $programType = $data['programType'];
            $data['init_workflow'] = true;
            $program = ProgramFactory::create($programType, $data);

            // Add it to the profile.
            $profile = Profile::find($data['profile_id']);
            $profile->addProgram($program);

            // Generate the start situation and add it both to profile and program.
            $situation = $profile->addSituationByData(__('Applying') , [
                'program_type' => $programType,
                'program_name' => $program->getAttribute('program_name')->getValue()
            ]);

            if($situation != null) {
                $program->addSituation($situation);
            }

            // Update the profile status.
            $profile->setValue('profile_status', 2);

            // Update cache
            DB::table('program_caches')
                ->insert([
                    'program_id' => $program->getId(),
                    'program_name' => $program->getValue('program_name'),
                    'program_type' => $program->getValue('program_type'),
                    'program_type_text' => "RAISING STARTS",
                    'profile_name' => $profile->getValue('name'),
                    'profile_logo' => $profile->getValue('profile_logo')['filelink'],
                    'profile_type' => $profile->getValue('is_company') ? 1 : 0,
                    'program_status' => $program->getStatus(),
                    'program_status_text' => $program->getStatusText(),
                    'ntp' => $program->getValue('ntp'),
                    'ntp_text' => $program->getText('ntp'),
                    'year' => date('Y', strtotime('+ 1 year', strtotime(now()))),
                ]);

        }

        if(isset($data['rstarts_logo'])) {
            $profile = $program->getProfile();
            $profile->setValue('profile_logo', $data['rstarts_logo']);
        }

        if($program instanceof RaisingStartsProgram)
        {
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

        return redirect(route('programs.profile', ['program' => $program->getId()]));

    }

    public function sessions($programId) {
//        $this->authorize('read_client_profile', [$id]);
        $program = ProgramFactory::resolve($programId);
        $profile = $program->getProfile();
        return view('programs.sessions', ['profile' => $profile, 'program' => $program]);
    }

    public function trainings($programId) {
        $program = ProgramFactory::resolve($programId);
        return view('programs.trainings', ['program' => $program]);
    }

    public function attendances(Request $request, $programId) {
        $program = ProgramFactory::resolve($programId);

        $attendances = $program->getAttendances();

        $data = $request->post();

        if($data['name'] != NULL) {
            $attendances = $attendances->where('training_name', $data['name']);
        }

        if($data['eventType'] != 0) {
            $attendances = $attendances->where('training_type', $data['eventType']);
        }

        if(isset($data['eventStatus']) && $data['eventStatus'] != 0) {
            $attendances = $attendances->where('event_status', $data['eventStatus']);
        }

        $resultData = [];
        foreach($attendances as $attendance) {
            $trainingData = $attendance->getTraining()->getData();
            $resultData[] = [
                'id' => $trainingData['id'],
                'name' => $trainingData['training_name'],
                'date' => date('d.m.Y', strtotime($trainingData['training_start_date'])),
                'type' => $trainingData['training_type'],
                'status' => $trainingData['event_status'],
                'location' => $trainingData['location'],
                'attendance' => $attendance->getValue('attendance')
            ];
        }

        return $resultData;
    }

    public function training($programId, $trainingId) {
        $training = Training::find($trainingId);
        $program = ProgramFactory::resolve($programId);
        $role = Auth::user()->roles->first()->name;
        $profile = $program->getProfile();

        return view('trainings.show1',
            [
                'training' => $training,
                'profile' => $profile,
                'programId' => $program->getId(),
                'backroute' => route('programs.trainings', ['program' => $program->getId()]),
                'role' => $role
            ]);
    }

    /////
    /// STATISTICS ///
    ///
    public function getStatistics($programId): array
    {
        $program = Program::find($programId);
        return [
            'iznos_prihoda' => $program->getValue('iznos_prihoda'),
            'iznos_izvoza' => $program->getValue('iznos_izvoza'),
            'broj_zaposlenih' => $program->getValue('broj_zaposlenih'),
            'broj_angazovanih' => $program->getValue('broj_angazovanih'),
            'broj_angazovanih_zena' => $program->getValue('broj_angazovanih_zena'),
            'iznos_placenih_poreza' => $program->getValue('iznos_placenih_poreza'),
            'iznos_ulaganja_istrazivanje_razvoj' => $program->getValue('iznos_ulaganja_istrazivanje_razvoj'),
            'broj_malih_patenata' => $program->getValue('broj_malih_patenata'),
            'broj_patenata' => $program->getValue('broj_patenata'),
            'broj_autorskih_dela' => $program->getValue('broj_autorskih_dela'),
            'broj_inovacija' => $program->getValue('broj_inovacija'),
            'countries' => $program->getValue('countries'),
            'statistic_sent' => $program->getValue('statistic_sent')

        ];
    }

    public function updateStatistics(Request $request) {
        $data = $request->post();
        unset($data['statistic_sent']);

        $program = Program::find($data['id']);
        foreach($data as $key=>$value) {
            $program->setValue($key, $value);
        }

        $program->setValue('statistic_sent', 'on');

    }

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


}
