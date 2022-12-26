<?php

namespace App\Http\Controllers;

use App\User;
use App\Entity;
use App\Attribute;
use Hamcrest\Util;
use App\University;
use App\ProfileCache;
use App\Mail\TestMail;
use PHPUnit\Util\Test;
use App\AttributeGroup;
use App\Business\Profile;
use App\Business\Program;
use Illuminate\Support\Str;
use App\Mail\ProfileCreated;
use Illuminate\Http\Request;
use App\Business\RastuceProgram;
use Illuminate\Support\Facades\DB;
use App\Business\IncubationProgram;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Business\RaisingStartsProgram;
use App\Http\Requests\StorePostRequest;
use PharIo\Manifest\InvalidEmailException;
use App\Http\Requests\CreateProfileRequest;
use App\Http\Requests\StoreIncubationRequest;

class AnonimousController extends Controller
{
    /**
     * Leads to the page for anonimous profile account creation.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createProfile() {
        $attributes = collect(Profile::getAttributesDefinition());

        // Remove 'status' attribute.
        $attributes = $attributes->reject(function($item, $key) {
            return $item->name == 'profile_status';
        });

        $action = route('storeProfileAnonimous');
        return view('anonimous.createProfile', ['attributes' => $attributes, 'action' => $action]);
    }

    public function storeProfile(CreateProfileRequest $request) {
        $data = $request->post();

        $profile_photo = Utils::getFilesFromRequest($request, 'profile_logo');
        if($profile_photo != null) {
            $data['profile_logo'] = $profile_photo;
        }

        $profile_background = Utils::getFilesFromRequest($request, 'profile_background');
        if($profile_background != null) {
            $data['profile_background'] = $profile_background;
        }

        $data['profile_status'] = 2;

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

        // Go to confirmation page.
        $token = $user->getRememberToken();
        return redirect(route('user.notify', ['token' => $token]));
    }

    public function createIncubationBITF() {
        $attributeData = IncubationProgram::getAttributesDefinition();
        if(auth()->user() == null) $mode = 'anonimous'; else $mode = 'loggedin';
        return view(
            'anonimous.createIncubationBITF',
            [
                'attributes' => $attributeData['attributes'],
                'attributeGroups' => $attributeData['attributeGroups'],
                'mode' => $mode
            ]);
    }

    public function storeIncubationBITF(StoreIncubationRequest $request) {
        $data = $request->post();

        // Get the files
        $fileData = $this->addFileToData($request, 'resenje_fajl');
        if($fileData != null) {
            $data['resenje_fajl'] = $fileData;
        }

        $fileData = $this->addFileToData($request, 'founders_cv');
        if($fileData != null) {
            $data['founders_cv'] = $fileData;
        }

        // Always this value. (NTP Beograd)
        $data['ntp'] = 1;

        // Create Profile
        $profileData = [
            'name' => $data['program_name_or_company'],
            'is_company' => $data['legal_status'] == 2,
            'ntp' => $data['ntp'],
            'business_branch' => $data['business_branch'],
            'id_number' => $data['id_number'],
            'contact_person' => $data['responsible_firstname']. ' '.$data['responsible_lastname'],
            'contact_email' => $data['responsible_email'],
            'contact_phone' => $data['responsible_cellular'],
            'address' => $data['address'],
            'profile_webpage' => $data['web'],
            'profile_status' => 2,
            'profile_state' => 1,
        ];

        // Check Profile
        if(Attribute::checkValue( Entity::where('name', 'Profile')->first(), 'name', $profileData['name']))
        {
            // Profil postoji u bazi
            return redirect(route('wrongUserPassword'));

        }

        // Check User
        if(User::where('email', $profileData['contact_email'])->count() > 0) {
            // Postoji user u bazi sa tim imenom
            return redirect(route('wrongUserPassword'));
        }

        $profile = new Profile($profileData);
        $user = User::where('email', $data['responsible_email'])->first();
        if($user == null) {
            $user = User::create([
                'name' => $profileData['contact_person'],
                'email' => $profileData['contact_email'],
                'password' => Hash::make(Str::random(10)),
                'position' => "Odgovorno lice",
            ]);

            $user->setRememberToken(Str::random(60));
            $user->save();
            $user->assignRole('profile');
        }

        $profile->attachUser($user);

        // Create/Attach User
        if($profile->getAttribute('profile_status')->getValue() == 1) {
            $profile->addSituationByData(__('Mapped'), []);
        } else {
            $profile->addSituationByData(__('Interest'), []);
        }

        $program = new IncubationProgram($data);
        $profile->addProgram($program);
        $situation = $profile->addSituationByData(__('Applying'),
        [
            'program_type' => Program::$INKUBACIJA_BITF,
            'program_name' => "INCUBATION BITF"
        ]);
        $program->addSituation($situation);

        // Add founders
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


        $profile->setValue('profile_status', 3);
        $program->setStatus(1);
        $profile->updateState();

        // Send verification email to the user.
        $email = $profile->getAttribute('contact_email')->getValue();
        try {
            Mail::to($email)->send(new ProfileCreated($profile));
        } catch (\Exception $ioe) {

        }

        // Update Cache
        // Update Profile Cache
        ProfileCache::create([
            'profile_id' => $profile->getId(),
            'name' => $profile->getValue('name'),
            'logo' => $profile->getValue('profile_logo') != null ? $profile->getValue('profile_logo')['filelink'] : asset('/images/custom/nophoto2.png'),
            'membership_type' => $profile->getValue['membership_type'] ?? 0,
            'membership_type_text' => $profile->getText['membership_type'] ?? '',
            'ntp' => $profile->getValue('ntp') ?? 0,
            'ntp_text' => $profile->getText('ntp') ?? '',
            'profile_state' => $profile->getValue('profile_state'),
            'profile_state_text' => $profile->getText('profile_state'),
            'is_company' => $profile->getValue('is_company'),
            'is_company_text' => $profile->getValue('is_company') ? 'Kompanija' : 'Startap',
            'contact_person_name' => $profile->getValue('contact_person'),
            'contact_person_email' => $profile->getValue('contact_email'),
            'faza_razvoja' => $profile->getValue('faza_razvoja') ?? 0,
            'faza_razvoja_tekst' => $profile->getText('faza_razvoja') ?? '',
            'business_branch' => $profile->getValue('business_branch') ?? 0,
            'business_branch_text' => $profile->getText('business_branch') ?? '',
            'website' => $profile->getValue('profile_webpage') ?? '',
            'program_name' => $program->getValue('program_name') ?? ''
        ]);

        // Get current year


        // Update program cache
        DB::table('program_caches')
        ->insert([
            'program_id' => $program->getId(),
            'program_type' => $program->getValue('program_type'),
            'program_type_text' => $program->getValue('program_name'),
            'profile_name' => $profile->getValue('name'),
            'profile_logo' => $profile->getValue('profile_logo') != null ? $profile->getValue('profile_logo')['filelink'] : asset('/images/custom/nophoto2.png'),
            'program_status' => $program->getStatus(),
            'program_status_text' => $program->getStatusText(),
            'program_name' => $program->getValue('program_name'),
            'ntp_text' => $program->getText('ntp') ?? '',
            'year' => date('Y')
        ]);

        // Go to confirmation page.
        $token = $user->getRememberToken();
        return redirect(route('user.notify'));

    }

    public function createRastuce() {
        $attributeData = RastuceProgram::getAttributesDefinition();

        return view('anonimous.createRastuce',
        [
            'attributes' => $attributeData['attributes'],
            'attributeGroups' => $attributeData['attributeGroups']
        ]);
    }


    public function storeRastuce(Request $request) {
        $data = $request->post();
        var_dump($data);
        return true;
    }

    public function createRaisingStarts() {
       $attributeData = RaisingStartsProgram::getAttributesDefinition();

       if(auth()->user() == null) {
            $mode = 'anonimous';
            if(strtotime(now()) >= strtotime("2022-12-28 12:00:00")) {
                return view('anonimous.application-closed');
            }
       } else if(auth()->user()->roles->first()->name == 'profile') {
            return redirect(route('home'));
       } else {
            $mode = auth()->user()->roles->first()->name;
       }

       return view('anonimous.createRaisingStarts', ['attributes' => $attributeData['attributes'], 'mode' => $mode]);
    //    return view('anonimous.application-closed');
    }

    public function storeRaisingStarts(StorePostRequest $request) {
        $data = $request->post();

        $data['rstarts_logo'] = Utils::getFilesFromRequest($request, 'rstarts_logo');
        $data['rstarts_files'] = Utils::getFilesFromRequest($request, 'rstarts_files');
        $data['rstarts_financing_proof_files'] = Utils::getFilesFromRequest($request, 'rstarts_financing_proof_files');
        $data['rstarts_dodatni_dokumenti'] = Utils::getFilesFromRequest($request, 'rstarts_dodatni_dokumenti');
        $data['rstarts_founder_cvs'] = Utils::getFilesFromRequest($request, 'rstarts_founder_cvs');

        // Create Profile
        $profileData = [
            'name' => $data['rstarts_startup_name'],
            'is_company' => $data['app_type'] == 2,
            'ntp' => $data['ntp'],
            'id_number' => $data['rstarts_id_number'],
            'contact_person' => $data['rstarts_applicant_name'],
            'contact_email' => $data['rstarts_email'],
            'contact_phone' => $data['rstarts_telephone'],
            'address' => $data['rstarts_address'],
            'profile_webpage' => $data['rstarts_webpage'],
            'short_ino_desc' => $data['rstarts_short_ino_desc'],
            'profile_status' => 2,
            'profile_state' => 1,
            'profile_logo' => $data['rstarts_logo'],
            'profile_background' => [
                'filelink' => '',
                'filename' => ''
            ]
        ];


        // Check Profile
        if(Attribute::checkValue( Entity::where('name', 'Profile')->first(), 'name', $profileData['name']))
        {
            // Profil postoji u bazi
            return redirect(route('wrongUserPassword'));

        }

        // Check User
        if(User::where('email', $profileData['contact_email'])->count() > 0) {
            // Postoji user u bazi sa tim imenom
            return redirect(route('wrongUserPassword'));
        }


        $profile = new Profile($profileData);
        $user = User::where('email', $data['rstarts_email'])->first();
        if($user == null) {
            $user = User::create([
                'name' => $data['rstarts_applicant_name'],
                'email' => $data['rstarts_email'],
                'password' => Hash::make(Str::random(10)),
                'position' => "Odgovorno lice",
            ]);

            $user->setRememberToken(Str::random(60));
            $user->save();
            $user->assignRole('profile');
        }

        $profile->attachUser($user);

        // Create/Attach User
        if($profile->getAttribute('profile_status')->getValue() == 1) {
            $profile->addSituationByData(__('Mapped'), []);
        } else {
            $profile->addSituationByData(__('Interest'), []);
        }


        // create program
        $program = new RaisingStartsProgram($data);

        // get the team members
        if(isset($data['memberName'])) {
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
            }
        }


        // get the founders
        if(isset($data['founderName'])) {
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
            }
        }


        // attach program to profile
        $profile->addProgram($program);

        $situation = $profile->addSituationByData(__('Applying'),
            [
                'program_type' => Program::$RAISING_STARTS,
                'program_name' => 'RAISING STARTS'
            ]);

        $program->addSituation($situation);

        $profile->setValue('profile_status', 1);
        $program->setStatus(1);
        $profile->updateState();

        // Send verification email to the user.
        $email = $profile->getAttribute('contact_email')->getValue();
        try {
            Mail::to($email)->send(new ProfileCreated($profile));
        } catch (\Exception $ioe) {

        }

        $logoImage = asset('/images/custom/nophoto2.png');
        if($profile->getValue('profile_logo') != null && $profile->getValue('profile_logo')['filelink'] != "" ) {
            $logoImage = $profile->getValue('profile_logo')['filelink'];
        }

        // Update Cache
        // Update Profile Cache
        ProfileCache::create([
            'profile_id' => $profile->getId(),
            'name' => $profile->getValue('name'),
            'logo' => $logoImage,
            'membership_type' => $profile->getValue['membership_type'] ?? 0,
            'membership_type_text' => $profile->getText['membership_type'] ?? '',
            'ntp' => $profile->getValue('ntp') ?? 0,
            'ntp_text' => $profile->getText('ntp') ?? '',
            'profile_state' => $profile->getValue('profile_state'),
            'profile_state_text' => $profile->getText('profile_state'),
            'is_company' => $profile->getValue('is_company'),
            'is_company_text' => $profile->getValue('is_company') ? 'Kompanija' : 'Startap',
            'contact_person_name' => $profile->getValue('contact_person'),
            'contact_person_email' => $profile->getValue('contact_email'),
            'faza_razvoja' => $profile->getValue('faza_razvoja') ?? 0,
            'faza_razvoja_tekst' => $profile->getText('faza_razvoja') ?? '',
            'business_branch' => $profile->getValue('business_branch') ?? 0,
            'business_branch_text' => $profile->getText('business_branch') ?? '',
            'website' => $profile->getValue('profile_webpage'),
            'program_name' => $program->getValue('program_name')
        ]);

        // Update program cache
        DB::table('program_caches')
        ->insert([
            'program_id' => $program->getId(),
            'program_name' => $program->getValue('program_name'),
            'program_type' => $program->getValue('program_type'),
            'program_type_text' => $program->getValue('program_name'),
            'profile_name' => $profile->getValue('name'),
            'profile_logo' => $logoImage,
            'profile_type' => $profile->getValue('is_company') ? 1 : 0,
            'program_status' => $program->getStatus(),
            'program_status_text' => $program->getStatusText(),
            'ntp' => $program->getValue('ntp'),
            'ntp_text' => $program->getText('ntp'),
            'year' => date('Y', strtotime('+ 1 year', strtotime(now()))),
        ]);

        // Go to confirmation page.
        $token = $user->getRememberToken();
        return redirect(route('user.notify'));

    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('ntp')]);
    }

    /**
     * Creates the new unverified user account.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $data = $request->post();

        $data['profile_logo'] = Utils::getFilesFromRequest($request, 'profile_logo');
        $data['profile_background'] = Utils::getFilesFromRequest($request, 'profile_background');

        // Set as 'interested'.
        $data['profile_status'] = 2;

        $profile = new Profile($data);
        $user = User::where(['email' => $data['contact_email']])->first();

        if($user === null) {
            $user = User::create([
                'name' => $data['contact_person'],
                'email' => $data['contact_email'],
                'password' => Hash::make(Str::random(10)),
                'position' => "Zastupnik"
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

        // Send verification email to the user.
        $email = $profile->getAttribute('contact_email')->getValue();
        Mail::to($email)->send(new ProfileCreated($profile));

        // Go to confirmation page.
        $token = $user->getRememberToken();
        return redirect(route('user.notify', ['token' => $token]));

    }

    /**
     * Verification of user account.
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verify($token) {
        $user = User::where('remember_token', $token)->first();

        if($user != null) {
            $user->setAttribute('email_verified_at', now());
            $user->save();

            return view('auth.changepassword')->with(
                ['token' => $token, 'email' => $user->getAttribute('email')]
            );
        }

        return view('anonimous.wrong-page');

    }

    public function notifyUser() {
//        $user = User::where('remember_token', $token)->first();
//        if($user == null) {
//            abort(401);
//        }

        return view('anonimous.notify-user');
    }

    public function wrongUserPassword() {
        $poruka = "
            Profil koji ste uneli ili kontakt osoba već postoje u bazi.
            Molimo, prijavite se na svoj nalog, i prijavite se na program sa svog profila.
        ";

        return view('anonimous.notify-user', ['message' => htmlentities($poruka)]);
    }

    public function accountExpired() {
        return view('anonimous.account-expired');
    }

    public function formSent() {
        return view('anonimous.confsent');
    }

    public function testUser($userId) {
        $user = User::find($userId);
        echo 'Name of the user is '.$user->name.'<br />';
        echo 'Token is '.$user->getRememberToken().'<br />';
        die();
    }

    public function test() {
        return view('anonimous.test');
    }

    public function storeTest(Request $request) {
        $data = $request->post();

    }

    public function testMail($email) {
        try {
            Mail::to($email)->send(new TestMail());
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

    }

    public function construction() {
        return view('anonimous.construction');
    }

    public function toggleLocale() {
        $locale = session('locale');
        var_dump($locale);
        if($locale == null) {
            $locale = app()->getLocale();
        }

        if($locale == 'sr-RS') {
            $locale = "en";
        } else {
            $locale = "sr-RS";
        }
        var_dump($locale);
        session()->put('locale', $locale);
        return "success";
    }

    public function universities() {
        $universities = University::all()->map(function($university) {
            return [
                'value' => $university->id,
                'text' => $university->name
            ];
        });

        return $universities;

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
