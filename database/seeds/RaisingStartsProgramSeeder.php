<?php

use App\Business\Profile;
use App\Business\Program;
use App\Business\RaisingStartsProgram;
use App\Mail\ProfileCreated;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RaisingStartsProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 12; $i++) {
            $program = $this->createProgram();
            echo $program->getProfile()->getValue('name').' created <br />';
        }

    }

    private function createProgram() {
        $name = Faker\Provider\sr_Latn_RS\Person::firstNameFemale();
        $faker = \Faker\Factory::create('sr_RS');
        $programData = [
            'program_type' => \App\Business\Program::$RAISING_STARTS,
            'program_name' => 'RAISING STARTS',
            'program_status' => 2,
            'ntp' => $faker->numberBetween(1,3),
            'app_type' => $faker->numberBetween(1,2),
            'rstarts_startup_name' => $faker->company,
            'rstarts_applicant_name' => $faker->name,
            'rstarts_position' => 'Direktor',
            'rstarts_address' => $faker->address,
            'rstarts_email' => $faker->email,
            'rstarts_telephone' => $faker->e164PhoneNumber,
            'rstarts_logo' => [
                'filename' => $faker->image(),
                'filelink' => $faker->imageUrl()
            ],
            'rstarts_webpage' => $faker->url,
            'rstarts_founding_date' => $faker->date('d.m.Y.'),
            'rstarts_id_number' => $faker->randomNumber(8),
            'rstarts_basic_registered_activity' => $faker->numerify('###-####'),
            'rstarts_short_ino_desc' => $faker->text(),
            'rstarts_product_type' => $faker->numberBetween(1,3),
            'rstarts_team_history' => $faker->text(),
            'rstarts_app_motive' => $faker->text(),
            'rstarts_tagline' => $faker->text(),
            'rstarts_solve_problem' => $faker->text(),
            'rstarts_targetted_market' => $faker->text(),
            'rstarts_problem_solve' => $faker->text(),
            'rstarts_which_product' => $faker->text(),
            'rstarts_benefits' => $faker->text(),
            'rstarts_customer_problem_solve' => $faker->text(),
            'rstarts_how_innovative' => $faker->numberBetween(1,5),
            'rstarts_clarification_innovative' => $faker->text(),
            'rstarts_dev_phase_tech' => $faker->numberBetween(1, 6),
            'rstarts_dev_phase_bussines' => $faker->numberBetween(1,9),
            'rstarts_intellectual_property' => $faker->numberBetween(1,6),
            'rstarts_research' => $faker->text(),
            'rstarts_innovative_area' => $faker->text(),
            'rstarts_business_plan' => $faker->text(),
            'rstarts_statup_progress' => $faker->text(),
            'rstarts_mentor_program_history' => $faker->text(),
            'rstarts_financing_sources' => $faker->text(),
            'rstarts_expectations' => $faker->text(),
            'rstarts_howmuchmoney' => $faker->text(),
            'rstarts_linkclip' => 'https://youtu.be/JxWztl0LL9w',
            'rstarts_howdiduhear' => $faker->numberBetween(1,5),
            'rstarts_other_sources' => $faker->text(),
        ];

        $file = $faker->file('public/storage', 'public/documents');
        $file = str_replace('public/documents\\', '', $file);
        $filelink = asset('documents/'.$file);

        $file1 = $faker->file('public/storage', 'public/documents');
        $file1 = str_replace('public/documents\\', '', $file1);
        $filelink1 = asset('documents/'.$file1);

        $programData['rstarts_founder_cvs'] = [
            [
                'filename' => $file,
                'filelink' => $filelink
            ],
            [
                'filename' => $file1,
                'filelink' => $filelink1
            ]
        ];


        $programData['rstarts_files'] = [
            [
                'filename' => $file,
                'filelink' => $filelink
            ],
            [
                'filename' => $file1,
                'filelink' => $filelink1
            ]
        ];

        $programData['rstarts_financing_proof_files'] = [
            [
                'filename' => $file,
                'filelink' => $filelink
            ],
            [
                'filename' => $file1,
                'filelink' => $filelink1
            ]
        ];

        $programData['rstarts_dodatni_dokumenti'] = [
            [
                'filename' => $file,
                'filelink' => $filelink
            ],
            [
                'filename' => $file1,
                'filelink' => $filelink1
            ]
        ];

        // Create Profile
        $profileData = [
            'name' => $programData['rstarts_startup_name'],
            'is_company' => $programData['app_type'] == 2,
            'id_number' => $programData['rstarts_id_number'],
            'contact_person' => $programData['rstarts_applicant_name'],
            'contact_email' => $programData['rstarts_email'],
            'contact_phone' => $programData['rstarts_telephone'],
            'address' => $programData['rstarts_address'],
            'short_ino_desc' => $programData['rstarts_short_ino_desc'],
            'profile_status' => 2,
            'profile_logo' => $programData['rstarts_logo'],
            'profile_background' => [
                'filelink' => $faker->imageUrl(),
                'filename' => $faker->image()
            ]
        ];

        $profile = new Profile($profileData);
        $user = User::where('email', $profileData['contact_email'])->first();
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

        // create program
        $program = new RaisingStartsProgram($programData);

        $membersData = [];
        for($i = 0; $i < 2; $i++) {
            $membersData[] = [
                'team_member_name' => $faker->name,
                'team_education' => $faker->word,
                'team_role' => $faker->word,
                'team_other_job' => $faker->word
            ];
        }

        $program->updateTeamMembers($membersData);

        $foundersData = [];
        for($i = 0; $i < 2; $i++) {
            $foundersData[] = [
                'founder_name' => $faker->name,
                'founder_part' => $faker->numberBetween(1,100)
            ];
        }

        $program->updateFounders($foundersData);

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

        return $program;
    }
}
