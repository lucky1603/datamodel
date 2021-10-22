<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeGroup;
use App\Business\Profile;
use App\Business\Program;
use App\Business\RaisingStartsProgram;
use App\Http\Requests\StorePostRequest;
use App\Mail\ProfileCreated;
use App\User;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        return view('profiles.create', ['attributes' => $attributes, 'action' => $action]);
    }

    public function createRaisingStarts() {
        $attributeData = RaisingStartsProgram::getAttributesDefinition();
        return view('anonimous.createRaisingStarts', ['attributes' => $attributeData['attributes']]);
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
            'id_number' => $data['rstarts_id_number'],
            'contact_person' => $data['rstarts_applicant_name'],
            'contact_email' => $data['rstarts_email'],
            'contact_phone' => $data['rstarts_telephone'],
            'address' => $data['rstarts_address'],
            'university' => 0,
            'short_ino_desc' => $data['rstarts_short_ino_desc'],
            'business_branch' => $data['rstarts_basic_registered_activity'],
            'reason_contact' => 0,
            'note' => '',
            'profile_status' => 2,
            'profile_logo' => $data['rstarts_logo'],
            'profile_background' => [
                'filelink' => '',
                'filename' => ''
            ]
        ];

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
        }

        // attach program to profile
        $profile->addProgram($program);

        $profile->addSituationByData(__('Application Sent'),
            [
                'program_type' => Program::$RAISING_STARTS,
                'program_name' => 'RAISING STARTS'
            ]);

        $profile->setValue('profile_status', 3);
        $program->setStatus(2);

        // Send verification email to the user.
        $email = $profile->getAttribute('contact_email')->getValue();
        Mail::to($email)->send(new ProfileCreated($profile));

        // Go to confirmation page.
        $token = $user->getRememberToken();
        return redirect(route('user.notify', ['token' => $token]));

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

        $user->setAttribute('email_verified_at', now());
        $user->save();

        return view('auth.changepassword')->with(
            ['token' => $token, 'email' => $user->getAttribute('email')]
        );
    }

    public function notifyUser($token) {
        $user = User::where('remember_token', $token)->first();
        if($user == null) {
            abort(401);
        }

        return view('anonimous.notify-user');
    }

    public function testUser($userId) {
        $user = User::find($userId);
        echo 'Name of the user is '.$user->name.'<br />';
        echo 'Token is '.$user->getRememberToken().'<br />';
        die();
    }
}
