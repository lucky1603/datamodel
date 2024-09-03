<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AbilityRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ability_role')->truncate();
        DB::table('abilities')->truncate();
        DB::table('roles')->truncate();

        DB::statement('ALTER TABLE abilities AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE ability_role AUTO_INCREMENT = 0');


        $abilities = [
            /* 1 */ "read_client_profile" => "Čitanje podataka klijenata",
            /* 2 */ "write_client_profiles" => "Upisivanje/izmena podataka klijenata",
            /* 3 */ "manage_client_profiles" => "Dodavanje/brisanje klijenata",
            /* 4 */ "list_client_profiles" => "Pregled klijenata",
            /* 5 */ "change_client_status" => "change_client_status",
            /* 6 */ "read_contract" => "Čitanje podataka ugovora",
            /* 7 */ "write_contract" => "Upisivanje/izmena podataka ugovora",
            /* 8 */ "manage_contracts" => "Dodavanje/brisanje ugovora",
            /* 9 */ "read_event_data" => "Čitanje podataka događaja",
            /* 10 */ "manage_events" => "Dodavanje/brisanje događaja",
            /* 11 */ "write_event_data" => "Upis/izmena podataka događaja",
            /* 12 */ "read_situation_data" => "Čitanje podataka situacije",
            /* 13 */ "manage_situations" => "Dodavanje/brisanje situacije",
            /* 14 */ "change_situation_details" => "Promena podataka situacije",
            /* 15 */ "add_users" => "Dodavanje korisnika sistema",
            /* 16 */ "delete_users" => "Brisanje korisnika sistema",
            /* 17 */ "read_user_data" => "Čitanje korisničkih podataka",
            /* 18 */ "write_user_data" => "Upis/promena korisničkih podataka",
            /* 19 */ "read_session_data" => "Pregled podataka o mentorskoj sesiji",
            /* 20 */ "write_session_data" => "Upis/promena podataka o mentorskoj sesiji",
            /* 21 */ "manage_mentor_session" => "Manipulisanje mentorskim sesijama",
            /* 22 */ "read_program" => "Citanje podataka programa",
            /* 23 */ "read_statistics" => "Pregled podataka statistike",
            /* 24 */ "manage_program" => "Dodavanje/brisanje programa",
            /* 25 */ "list_programs  " => "Prikaz liste programa",
            /* 26 */ "list_mentors" => "Pregled liste mentora",
            /* 27 */ "manage_mentors" => "Izmena podataka mentora",
            /* 28 */ "manage_forms" => "Upravljanje formama za prijavu",
            /* 29 */ "delete_program" => "Brisanje programa",
            /* 30 */ "delete_profile" => "Brisanje profila",    
        ];

        foreach ($abilities as $key => $value) {
            DB::table('abilities')->insert([
                'name' => $key,
                'label' => $value
            ]);
        }

        $roles = [
            /* 1 */ "admin" => "Administrator",
            /* 2 */ "client" => "Klijent",  
            /* 3 */ "profile" => "Profil",
            /* 4 */ "mentor" => "Mentor",
            /* 5 */ "operator" => "Operator",
        ];

        foreach ($roles as $key => $value) {
            DB::table('roles')->insert([
                'name' => $key,
                'label' => $value
            ]);
        }   

        // ability_role table
        $roles = [
            1 => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
            2 => [1,2,4,5,6,9,12],
            3 => [1,2,4,5,6,9,12],
            4 => [1,4,9,12,19,20,21],
            5 => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,19,20,21,22,23,24,25,26,27],
        ];

        foreach ($roles as $key => $value) {
            foreach($value as $ability) {
                DB::table('ability_role')->insert([
                    'role_id' => $key,
                    'ability_id' => $ability
                ]);
            }            
        }

        Schema::enableForeignKeyConstraints();
    }
}
