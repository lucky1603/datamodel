<?php

use Illuminate\Database\Seeder;

class RaisingStartsProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            'rstarts_founder_cvs' => [
                [
                    'filename' => $faker->image(),
                    'filelink' => $faker->imageUrl()
                ],
                [
                    'filename' => $faker->image(),
                    'filelink' => $faker->imageUrl()
                ],

            ],
            'rstarts_team_history' => $faker->text(),
            'rstarts_app_motive' => $faker->text(),
        ];
    }
}
