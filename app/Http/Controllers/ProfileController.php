<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeGroup;
use App\Business\BusinessModel;
use App\Business\Client;
use App\Business\Contract;
use App\Business\DemoDay;
use App\Business\Founder;
use App\Business\IncubationProgram;
use App\Business\Mentor;
use App\Business\Preselection;
use App\Business\Profile;
use App\Business\Program;
use App\Business\ProgramFactory;
use App\Business\RaisingStartsProgram;
use App\Business\Selection;
use App\Business\Situation;
use App\Business\TeamMember;
use App\Business\Training;
use App\Exports\ProfileExport;
use App\Exports\RaisingStartsProgramExport;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateRaisingStartsRequest;
use App\Mail\ApplicationSuccess;
use App\Mail\CustomMessage;
use App\Mail\DemoDayNotification;
use App\Mail\MeetingNotification;
use App\Mail\ProfileCreated;
use App\Mail\ProfileRejected;
use App\ProfileCache;
use App\User;
use App\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
        $role = Auth::user()->roles()->first()->name;
        $token = csrf_token();
        return view('profiles.index1', ['profiles' => $profiles, 'role' => $role, 'token' => $token]);
    }

    public function otherCompanies($profileId) {
        $profile = Profile::find($profileId);
        $role = Auth::user()->roles()->first()->name;
        return view('profiles.other-profiles', ['model' => $profile, 'role' => $role]);
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
        return view('profiles.show1', ['model' => $profile, /* 'situations' => $situations */]);
    }

    public function create() {

        $this->authorize('manage_client_profiles');

        $attributes = collect(Profile::getAttributesDefinition());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
            return $item->name == 'profile_status';
        });

        $action = route('profiles.store');
        $token = csrf_token();
        return view('profiles.create', ['attributes' => $attributes, 'action' => $action, 'token' => $token]);
    }

    public function edit($profileId) {
        $this->authorize('manage_client_profiles');

        $profile = Profile::find($profileId);
        $attributes = $profile->getAttributes();
        $action = route('profiles.update');
        $token = csrf_token();

        return view('profiles.edit', ['profile' => $profile, 'attributes' => $attributes, 'action' => $action, 'token' => $token]);
    }

    public function update(StoreProfileRequest $request) {
        $data = $request->post();

        $profile_photo = Utils::getFilesFromRequest($request, 'profile_logo');
        if($profile_photo != null && $profile_photo != ['filelink' => '', 'filename' => '']) {
            $data['profile_logo'] = $profile_photo;
        }

        $profile_background = Utils::getFilesFromRequest($request, 'profile_background');
        if($profile_background != null && $profile_background != ['filelink' => '', 'filename' => '']) {
            $data['profile_background'] = $profile_background;
        }

        $profile = Profile::find($data['profileid']);
        $profile->setData($data);

        // Update cache
        $pcache = ProfileCache::where('profile_id', $data['profileid'])->first();
        $pcache->name = $data['name'];
        $pcache->logo = $profile->getValue('profile_logo')['filelink'];
        $pcache->save();

    }

    public function store(StoreProfileRequest $request) {
        $data = $request->post();

        // If the client fills it set the status to 'interested'
        if(auth()->user()->isRole('client')) {
            $data['profile_status'] = 2;
        }
        // If the NTP operator fills it set the status to 'mapped'
        if(auth()->user()->isAdmin()) {
            $data['profile_status'] = 1;
        }

        $profile_photo = Utils::getFilesFromRequest($request, 'profile_logo');
        if($profile_photo != null) {
            $data['profile_logo'] = $profile_photo;
        }

        $profile_background = Utils::getFilesFromRequest($request, 'profile_background');
        if($profile_background != null) {
            $data['profile_background'] = $profile_background;
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

        // Sync current profile state with its status.
        $profile->updateState();

        if($profile->getAttribute('profile_status')->getValue() == 1) {
            $profile->addSituationByData(__('Mapped'), []);
        } else {
            $profile->addSituationByData(__('Interest'), []);
        }

        // TODO - Send email to the user.
        $email = $profile->getAttribute('contact_email')->getValue();
        Mail::to($email)->send(new ProfileCreated($profile));

        if(Auth::user()->isAdmin()) {
            return redirect(route('profiles.index'));
        }

        // Go to confirmation page.
        $token = $user->getRememberToken();
        return redirect(route('user.notify', ['token' => $token]));

    }

    public function reports($id) {
        $profile = Profile::find($id);
        return view('profiles.reports', ['model' => $profile]);
    }

    public function trainings($id) {
        $this->authorize('read_client_profile', [$id]);
        $profile = Profile::find($id);
        return view('profiles.trainings', ['model' => $profile]);
    }

    public function sessions($id) {
        $this->authorize('read_client_profile', [$id]);
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
        $this->authorize('read_client_profile', [$id]);
        $profile = Profile::find($id);
        if(!auth()->user()->isAdmin()) {
            $this_profile = auth()->user()->profile();
            if($this_profile->getId() != $profile->getId()) {
                abort(401);
            }
        }

        $program = $profile->getActiveProgram();
        if($program != null &&
            $profile->getAttribute('profile_status')->getValue() == 3 &&
            $program->getStatus() == 1) {
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

        return view('profiles.profile1', ['model' => $profile]);
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
            $program = ProgramFactory::create($programType, $data);

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
            $profile->updateState();

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
            return json_encode([
                'code' => 0,
                'message' => `No profile with id = {$profileId}`
            ]);
        }

        $program = $profile->getActiveProgram();
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

        } else if($programType == Program::$RAISING_STARTS) {
            if(!auth()->user()->isAdmin()) {
                // Check for the date.
                $end = strtotime('2021-12-30 12:00');
                $now = strtotime(now());
                if($now > $end) {
                    return json_encode([
                        'code' => 0,
                        'message' => 'Rok za prijavljivanje je prošao!',
                    ]);
                }
            }

            $assertion = $this->checkRaisingStartsProgramData($program);
            if($assertion['code'] == 0) {
                return json_encode($assertion);
            }
        }

        $profile->addSituationByData(__('Application Sent'),
            [
                'program_type' => $program->getAttribute('program_type')->getValue(),
                'program_name' => $program->getAttribute('program_name')->getValue()
            ]);

        $program->setStatus(2);
        $profile->updateState();

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

    /**
     * Evaluacija faze prstupa programu pre prelaska na sledecu.
     * @param Request $request
     * @return array|void
     */
    public function evalPhase(Request $request) {
        $data = $request->post();

        if(!isset($data['profile'])) {
            return [
                'code' => 1,
                'message' => __('Wrong parameters')
            ];
        }

        $profileId = $data['profile'];
        $profile = Profile::find($profileId);
        if($profile === null) {
            return [
                'code' => 2,
                'message' => __('Profile doesn\'t exist'),
            ];
        }

        $program = $profile->getActiveProgram(true);

        if($data['passed'] == 'on') {
            $validation = $program->workflow->getCurrentPhase()->validateData($data);
            if($validation['code'] != 0) {
                return $validation;
            }

            if($program->workflow->isLastStep())
            {
                // Set data.
                $program->workflow->getCurrentPhase()->setData($data);

                $profile->setValue('profile_status', 4);
                $profile->addSituation(new Situation([
                    'name' => 'U PROGRAMU',
                    'description' => 'Klijent je počeo da koristi program',
                    'sender' => 'NTP'
                ]));

                // Dodaj izveštaje
                $program->initReports();

            } else {
                $programStatus = $program->getStatus();
                $phase = $program->workflow->getCurrentPhase();
                $phase->setData($data);
                if($phase->requiresExitSituation()) {
                    $situation = $phase->getExitSituation();
                    if($situation != null)
                        $profile->addSituation($phase->getExitSituation());
                }

                if($phase->requiresExitEmail()) {
                    Mail::to($profile->getValue('contact_email'))->send($phase->getExitEmailTemplate());
                }

                $program->setStatus($programStatus + 1);
                $phase = $program->workflow->getCurrentPhase();
                if($phase->requiresEntrySituation()) {
                    $situation = $phase->getEntrySituation();
                    if($situation != null)
                        $profile->addSituation($phase->getEntrySituation());
                }
                if($phase->requiresEntryEmail()) {
                    Mail::to($profile->getValue('contact_email'))->send($phase->getEntryEmailTemplate());
                }
            }
        } else {
            $profile->setValue('profile_status', 5);
            $phase = $program->workflow->getCurrentPhase();
            $phase->setData($data);


            if($phase->requiresExitSituation()) {
                $profile->addSituation($phase->getExitSituation());
            } else {
                $profile->addSituation(new Situation([
                    'name' => 'ODBIJEN',
                    'description' => 'Klijent je odbijen u fazi - "'.$phase->getDisplayName().'".',
                    'sender' => 'NTP'
                ]));
            }

            if($phase->requiresExitEmail()) {
                Mail::to($profile->getValue('contact_email'))->send($phase->getExitEmailTemplate());
            }
        }

        $profile->updateState();

        return [
            'code' => 0,
            'message' => __('Eval successfull!'),
        ];
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

                // Send rejection email to the user.
                $email = $profile->getAttribute('contact_email')->getValue();
                Mail::to($email)->send(new DemoDayNotification($profile, false));
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
            $profile->setData(['profile_status' => 5]);

            // Send rejection email to the user.
            $email = $profile->getAttribute('contact_email')->getValue();
            Mail::to($email)->send(new ProfileRejected($profile));
        }

        return [
            'code' => 0,
            'message' => 'Success'
        ];

    }

    public function evalDemoDay(Request $request) {
        $data = $request->post();

        if(!isset($data['profile'])) {
            return [
                'code' => 1,
                'message' => __('Wrong Parameters'),
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

            // Add situation.
            $profile->addSituationByData(__('Demo Day Passed'), [
                'demoday_passed' => true
            ]);

            $profile->setValue('profile_status', 6);

            // Add selection to profile.
            $profile->getActiveProgram()->addSelection(new Selection());

            // Send rejection email to the user.
            $email = $profile->getAttribute('contact_email')->getValue();
            Mail::to($email)->send(new DemoDayNotification($profile, true));

        } else {
            // Add situation (preselection result).
            $profile->addSituationByData(__('Demo Day Passed'), [
                'demoday_passed' => false
            ]);

            // Set status 'rejected'
            $profile->setData(['profile_status' => 9]);

            // Send rejection email to the user.
            $email = $profile->getAttribute('contact_email')->getValue();
            Mail::to($email)->send(new ProfileRejected($profile));
        }
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

    public function getProfileData($profileId) {
        $profile = Profile::find($profileId);
        return $profile->getData();
    }

    public function getProfileTexts($profileId) {
        $profile = Profile::find($profileId);
        $attributes = $profile->getAttributes();
        $programData = [];
        foreach($attributes as $attribute) {
            if($attribute->name == 'profile_logo' || $attribute->name == 'profile_background') {
                $programData[$attribute->name] = $attribute->getValue()['filelink'];
            } else {
                $programData[$attribute->name] = $attribute->getText();
            }

        }
        $program = $profile->getActiveProgram();
        $programData['program_type'] = $program->getValue('program_type');
        $programData['program_name'] = $program->getValue('program_name');
        $programData['programid'] = $program->getId();
        return $programData;
    }

    /**
     * Gets the profile data for the given program.
     * @param $programId
     * @return false|string
     */
    public function getProgramData($programId)
    {
        $program = ProgramFactory::resolve($programId);
        $profile = $program->getProfile();

        $data = [];

        $order = [
            'name',
            'is_company',
            'id_number',
            'contact_person',
            'contact_email',
            'contact_phone',
            'address',
            'university',
            'short_ino_desc',
            'business_branch',
            'profile_logo',
            'profile_background',
            'membership_type'
        ];

        foreach($order as $key) {
            $attribute = $profile->getAttribute($key);
            if($attribute->name == 'program_name')
                continue;
            if(!in_array($attribute->name, ['profile_logo', 'profile_background'])) {
                $data[$attribute->name] = [
                    'label' => $attribute->label,
                    'value' => $attribute->getText()
                ];
            } else {
                if($key == 'profile_logo')
                    $defaultImage = asset('/images/custom/nophoto2.png');
                else
                    $defaultImage = asset('/images/custom/backdefault.jpg');

                $img = $attribute->getValue() != null && $attribute->getValue()['filelink'] != '' ? $attribute->getValue()['filelink'] : $defaultImage;
                $data[$attribute->name] = [
                    'label' => $attribute->label,
                    'value' => $img,
                ];
            }

        }

        $data['programName'] = $program->getValue('program_name');
        $data['profileId'] = $profile->getId();

        return json_encode($data);
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

    public function getProgramsForMentor($mentorId) {
        $mentor = Mentor::find($mentorId);
        $programs = $mentor->getPrograms()->map(function($program) {
            return new class($program) {
                public $id;
                public $photo;
                public $name;
                public function __construct($program)
                {
                    $profile = $program->getProfile();
                    $this->id = $program->getId();
                    $profile_logo = $profile->getValue('profile_logo');
                    $this->photo = $profile_logo != null ? $profile_logo['filelink'] : asset('/images/custom/nophoto2.png');
                    $this->name = $profile->getValue('name');
                }
            } ;
        });

        $arr = [];
        foreach ($programs as $program) {
            $arr[] = $program;
        }

        return $arr;
    }

    public function getTrainingCandidates(): array
    {
        $programs = Program::find();
        $candidates = [];
        $filteredPrograms = $programs->filter(function($program) {
            return $program->isEventCandidate();
        });

        foreach($filteredPrograms as $program) {
            $candidates[] = [
                'id' => $program->getId(),
                'programType' => $program->getValue('program_type'),
                'programName' => $program->getvalue('program_name'),
                'profile' => $program->getProfile()->getValue('name')
            ];
        }

        return $candidates;
    }

    public function list() {
        return Profile::find()->map(function($profile) {
            return new class($profile) {
                public $id;
                public $name;
                public $logo;
                public $status;
                public $statusText;
                public $programType;
                public function __construct($profile)
                {
                    $this->id = $profile->getId();
                    $this->name = $profile->getValue('name');
                    $this->logo = $profile->getValue('profile_logo');
                    $this->status = $profile->getValue('profile_status');
                    $this->statusText = $profile->getText('profile_status');
                    if($profile->getActiveProgram() != null)
                        $this->programType = $profile->getActiveProgram()->getValue('program_type');
                    else
                        $this->programType = 0;
                }
            };
        });
    }

    public function filterTable() {
        Profile::find()->map(function($profile) {
            return [
                'id' => $profile->instance->id,
                'name' => $profile->getValue('name'),
                'photo' => $profile->getValue('profile_logo'),
                'membership_type' => $profile->getText('membership_type'),
            ];

        });
    }

    public function filterOtherCompanies($profileId) {
//        $this->authorize('read_client_profile', $profileId);
        return ProfileCache::all()
            ->where('profile_id','!=', $profileId)
            ->map(function($profile) {
            return new class($profile) {
                public $id;
                public $name;
                public $logo;
                public $website;
                public $contact_email;

                public function __construct($profile)
                {
                    $this->id = $profile->profile_id;
                    $this->name = $profile->name;
                    $this->logo = $profile->logo;
                    $this->website = $profile->website;
                    $this->contact_email = $profile->contact_person_email;
                }
            };
        });


    }

    public function filterCache(Request $request) {
        $data = $request->post();

        $filter = [];
        if($data['name'] == '') {
            unset($data['name']);
            Session::forget('name');
        }
        else {
            Session::put('name', $data['name']);
            $name = $data['name'];
            unset($data['name']);
        }


        if($data['profile_state'] == 0) {
            unset($data['profile_state']);
            Session::forget('profile_state');
        }
        else
            Session::put('profile_state', $data['profile_state']);

        if($data['is_company'] == -1) {
            unset($data['is_company']);
            Session::forget('is_company');
        } else {
            Session::put('is_company', $data['is_company']);
        }

        if($data['ntp'] == 0) {
            unset($data['ntp']);
            Session::forget('ntp');
        } else {
            Session::put('ntp', $data['ntp']);
        }

        if(count($data) == 0)
            $data = [];

        $query = count($data) ? DB::table('profile_caches')->where($data) : DB::table('profile_caches');
        if(isset($name)) {
            $query = $query->where('name', 'like', $name.'%');
        }

        return $query->select()
            ->get()
            ->map(function($profile) {
            return new class($profile) {
                public $id;
                public $name;
                public $logo;
                public $state;
                public $stateText;
                public $isCompany;
                public $ntp;
                public $program;
                public $membership_type;

                public function __construct($profile)
                {
                    $this->id = $profile->profile_id;
                    $this->name = $profile->name;
                    $this->logo = $profile->logo;
                    $this->state = $profile->profile_state;
                    $this->stateText = $profile->profile_state_text;
                    $this->isCompany = $profile->is_company_text;
                    $this->ntp = $profile->ntp_text;
                    $this->program = $profile->program_name;
                    $this->membership_type = $profile->membership_type_text;
                }
            };
        });
    }

    public function filter(Request $request) {
        $data = $request->post();

        $filter = [];
        if($data['name'] == '') {
            unset($data['name']);
            Session::forget('name');
        }
        else
            Session::put('name', $data['name']);

        if($data['profile_state'] == 0) {
            unset($data['profile_state']);
            Session::forget('profile_state');
        }
        else
            Session::put('profile_state', $data['profile_state']);

        if($data['is_company'] == -1) {
            unset($data['is_company']);
            Session::forget('is_company');
        } else {
            Session::put('is_company', $data['is_company']);
        }

        if($data['ntp'] == 0) {
            unset($data['ntp']);
            Session::forget('ntp');
        } else {
            Session::put('ntp', $data['ntp']);
        }

        if(count($data) == 0)
            $data = null;

        return Profile::find($data)->map(function($profile) {
            return new class($profile) {
                public $id;
                public $name;
                public $logo;
                public $state;
                public $stateText;
                public $background;
                public $isCompany;
                public $ntp;
                public $program;
                public $membership_type;

                public function __construct($profile)
                {
                    $this->id = $profile->getId();
                    $this->name = $profile->getValue('name');
                    $this->logo = $profile->getValue('profile_logo');
                    $attribute_state = $profile->getAttribute('profile_state');
                    $this->state = $attribute_state->getValue();
                    $this->stateText = $attribute_state->getText();
                    $this->isCompany = $profile->getValue('is_company');
                    $this->membership_type = $profile->getText('membership_type');
                    if($profile->getValue('attributes_cached') == false) {
                        $program = $profile->getActiveProgram();

                        $attribute = $program->getAttribute('ntp');
                        $text = $attribute->getText();
                        $value = $attribute->getValue();
                        $profile->setValue('ntp', $value);
                        $this->ntp = $text;

                        $attribute = $program->getAttribute('program_name');
                        $text = $attribute->getText();
                        $value = $attribute->getValue();
                        $profile->setValue('program_name', $value);
                        $this->program = $text;

                        $profile->setValue('attributes_cached', true);
                    } else {
                        $this->ntp = $profile->getText('ntp');
                        $this->program = $profile->getText('program_name');
                    }

                }
            };
        });

    }

    public function prepareMail() {
        $token = csrf_token();
        $content = "<p>Poštovani/a ,</p>
                    <p>Uskoro ističe rok za slanje prijava na program 'Raising Starts'.</p>
                    <p>Podsećamo Vas, da Vašu prijavu možete poslati najkasnije do 28.12. u 24:00h. Sve prijave poslate posle tog roka neće biti uzete u razmatranje.</p>
                    <p>Srdačan pozdrav,</p>
                    <p>Vaš NTP</p>";

        return view('profiles.preparemail', ['content' => $content, 'token' => $token]);

    }

    public function sendMail(Request $request) {
        $data = $request->post();
        var_dump($data);

        $profileIds = $data['recipients'];
        $content = $data['content'];

        var_dump($content);

        $emails = Profile::find()->filter(function($profile) use($profileIds) {
            return in_array($profile->getId(), $profileIds);
        })->map(function($profile) {
            return $profile->getValue('contact_email');
        });

        Mail::to($emails)->send(new CustomMessage($content));
        return redirect(route('profiles.index'));
    }

    public function getMailClients(): array
    {
        $clients = [];
        $profiles = Profile::find()->filter(function($profile) {
            return ( $profile->getValue('profile_state') == 2 /* && $profile->getActiveProgram()->getStatus() == 1 */);
        });
        foreach($profiles as $profile) {
            $clients[] = [
                'id' => $profile->getId(),
                'profile' => $profile->getValue('name'),
                'selected' => false
            ];
        }

        return $clients;
    }

    public function exportProfiles(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new ProfileExport, 'profile.xlsx');
    }

    public function exportRaisingStarts(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new RaisingStartsProgramExport, 'program.xlsx');
    }

    public function showTraining($profileId, $trainingId) {
        $training = Training::find($trainingId);
        $profile = Profile::find($profileId);
        $program = $profile->getActiveProgram();
        $role = Auth::user()->roles->first()->name;

        return view('trainings.show1',
            [
                'training' => $training,
                'profile' => $profile,
                'programId' => $program->getId(),
                'backroute' => route('profiles.trainings', ['profile' => $profile->getId()]),
                'role' => $role
            ]);
    }

    public function programAttendances(Request $request, $profileId) {
        $profile = Profile::find($profileId);
        if($profile == null) {
            return json_encode([
                'code' => 0,
                'message' => 'Nema profila sa id = ' . $profileId
            ]);
        }

        $program = $profile->getActiveProgram();
        if($program == null) {
            return json_encode([
                'code' => 0,
                'message' => 'Izabrani profil nema aktivni program!'
            ]);
        }

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

    public function setSessionVars(Request $request) {
        $data = $request->post();
        foreach($data as $key=>$value) {
            Session::put($key, $value);
        }

        var_dump($data);
        return "Session variables successfully changed!";
    }

    public function otherProfiles($profileId) {

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
