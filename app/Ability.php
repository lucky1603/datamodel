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
        if(Ability::whereName('read_user_profile')->first() == null) {
            Ability::create(['name' => 'read_user_profile']);
        }

        if(Ability::whereName('manage_user_profiles')->first() == null) {
            Ability::create(['name' => 'manage_user_profiles']);
        }

        if(Ability::whereName('change_user_profile')->first() == null) {
            Ability::create(['name' => 'change_user_profile']);
        }

        if(Ability::whereName('change_user_status')->first() == null) {
            Ability::create(['name' => 'change_user_status']);
        }

        if(Ability::whereName('read_contract')->first() == null) {
            Ability::create(['name' => 'read_contract']);
        }

        if(Ability::whereName('manage_contracts')->first() == null) {
            Ability::create(['name' => 'manage_contracts']);
        }

        if(Ability::whereName('change_contract_details')->first() == null) {
            Ability::create(['name' => 'change_contract_details']);
        }

        if(Ability::whereName('read_event_data')->first() == null) {
            Ability::create(['name' => 'read_event_data']);
        }

        if(Ability::whereName('manage_events')->first() == null) {
            Ability::create(['name' => 'manage_events']);
        }

        if(Ability::whereName('change_event_details')->first() == null) {
            Ability::create(['name' => 'change_event_details']);
        }

        if(Ability::whereName('read_situation_data')->first() == null) {
            Ability::create(['name' => 'read_situation_data']);
        }

        if(Ability::whereName('manage_situations')->first() == null) {
            Ability::create(['name' => 'manage_situations']);
        }

        if(Ability::whereName('change_situation_details')->first() == null) {
            Ability::create(['name' => 'change_situation_details']);
        }

        if(Ability::whereName('manage_users')->first() == null) {
            Ability::create(['name' => 'manage_users']);
        }
    }
}
