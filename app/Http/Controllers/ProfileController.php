<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeGroup;
use App\Business\BusinessModel;
use App\Business\Client;
use App\Business\Profile;
use App\Business\Program;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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

        // Hash code the password.
        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // If the client fills it set the status to 'interested'
        if(auth()->user()->isRole('client')) {
            $data['profile_status'] = 2;
        }
        // If the NTP operator fills it set the status to 'mapped'
        if(auth()->user()->isAdmin()) {
            $data['profile_status'] = 1;
        }

        $profile = new Profile($data);

        if($profile != null) {
            $user = User::where(['email' => $data['contact_email']])->first();

            if($user === null) {
                $user = User::create([
                    'name' => $data['contact_person'],
                    'email' => $data['contact_email'],
                    'password' => $data['password'],
                    'position' => "Zastupnik"
                ]);

                $user->assignRole('profile');
            }

            // Attach default user to the instance.
            $profile->attachUser($user);

            if($profile->getAttribute('profile_status')->getValue() == 1) {
                $profile->addSituationByData(__('Mapped'), []);
            } else {
                $profile->addSituationByData(__('Interest'), []);
            }

        }

        // TODO - Send email to the user.
        return redirect(route('profiles.index'));

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
                    'instance_id' => $program->instance->id
                ]);
        }

        return view('profiles.profile', ['model' => $profile]);
    }

    /**
     * Shows the form for the application for a program.
     * @param $programType
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
     * @param Profile $profile
     */
    public function saveApplicationData(Request $request) {
        $data = $request->post();
//        foreach($data as $key => $value) {
//            echo "data[".$key."] = ".$value."<br />";
//        }
//        die();

        $fileData = $this->addFileToData($request, 'resenje_fajl');
        if($fileData != null) {
            $data['resenje_fajl'] = $fileData;
        }

        $fileData = $this->addFileToData($request, 'founders_cv');
        if($fileData != null) {
            $data['founders_cv'] = $fileData;
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
            $profile->addSituationByData('Applying', [
                'program_type' => $programType
            ]);

            // Update the profile status.
            $profile->setData(['profile_status' => 3]);
        }

        return redirect(route('home'));

    }

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
            if(!isset($data['resenje']) && $data['resenje_fajl']['filelink'] == '') {
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

        $profile->getAttribute('profile_status')->setValue(4);

        $profile->addSituationByData(__('Application Sent'), ['program_type' => '5']);

        return json_encode([
            'code' => 1,
            'message' => "Provera uspesna"
        ]);

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
}
