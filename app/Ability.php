<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    /**
     * We are free to add anything alone.
     * @var array
     */
    protected $guarded = [];

    /**
     * Roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public static function initValues() {
        if(Ability::whereName('read_client_profile')->first() == null) {
            Ability::create(['name' => 'read_client_profile', 'label' => ' Čitanje podataka klijenta']);
        }

        if(Ability::whereName('write_client_profiles')->first() == null) {
            Ability::create(['name' => 'write_client_profiles', 'label' => 'Upisivanje/izmena podataka klijenata']);
        }

        if(Ability::whereName('manage_client_profiles')->first() == null) {
            Ability::create(['name' => 'manage_client_profiles', 'label' => 'Dodavanje/brisanje klijenata']);
        }

        if(Ability::whereName('list_client_profiles')->first() == null) {
            Ability::create(['name' => 'list_client_profiles', 'label' => 'Pregled klijenata']);
        }

        if(Ability::whereName('change_client_status')->first() == null) {
            Ability::create(['name' => 'change_client_status', 'label' => 'Promena statusa klijenta']);
        }

        if(Ability::whereName('read_contract')->first() == null) {
            Ability::create(['name' => 'read_contract', 'label' => 'Čitanje podataka ugovora']);
        }

        if(Ability::whereName('write_contract')->first() == null) {
            Ability::create(['name' => 'write_contract', 'label' => 'Upisivanje/izmena podataka ugovora']);
        }

        if(Ability::whereName('manage_contracts')->first() == null) {
            Ability::create(['name' => 'manage_contracts', 'label' => 'Dodavanje/brisanje ugovora']);
        }

        if(Ability::whereName('read_event_data')->first() == null) {
            Ability::create(['name' => 'read_event_data', 'label' => 'Čitanje podataka događaja']);
        }

        if(Ability::whereName('manage_events')->first() == null) {
            Ability::create(['name' => 'manage_events', 'label' => 'Dodavanje/brisanje događaja']);
        }

        if(Ability::whereName('write_event_data')->first() == null) {
            Ability::create(['name' => 'write_event_data','label' => 'Upis/izmena podataka događaja']);
        }

        if(Ability::whereName('read_situation_data')->first() == null) {
            Ability::create(['name' => 'read_situation_data', 'label' => 'Čitanje podataka o situaciji']);
        }

        if(Ability::whereName('manage_situations')->first() == null) {
            Ability::create(['name' => 'manage_situations', 'label' => 'Dodavanje/brisanje situacija']);
        }

        if(Ability::whereName('change_situation_details')->first() == null) {
            Ability::create(['name' => 'change_situation_details', 'label' => 'Promena podataka situacije']);
        }

        if(Ability::whereName('add_users')->first() == null) {
            Ability::create(['name' => 'add_users', 'label' => 'Dodavanje korisnika sistema']);
        }

        if(Ability::whereName('delete_users')->first() == null) {
            Ability::create(['name' => 'delete_users', 'label' => 'Brisanje korisnika sistema']);
        }

        if(Ability::whereName('read_user_data')->first() == null) {
            Ability::create(['name' => 'read_user_data', 'label' => 'Čitanje korisničkih podataka']);
        }

        if(Ability::whereName('write_user_data')->first() == null) {
            Ability::create(['name' => 'write_user_data', 'label' => 'Upis/promena korisničkih podataka']);
        }

        if(Ability::whereName('read_session_data')->first() == null) {
            Ability::create(['name' => 'read_session_data', 'label' => 'Pregled podataka o mentorskoj sesiji']);
        }

        if(Ability::whereName('write_session_data')->first() == null) {
            Ability::create(['name' => 'write_session_data', 'label' => 'Azuriranje podataka o mentorskoj sesiji']);
        }

        if(Ability::whereName('manage_mentor_session')->first() == null) {
            Ability::create(['name' => 'manage_mentor_session', 'label' => 'Manipulisanje mentorskim sesijama']);
        }

    }
}
