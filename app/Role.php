<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function abilities() {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }

    public function allowTo($ability) {
        if(is_string($ability)) {
            $ability = Ability::whereName($ability)->firstOrFail();
        }

        $this->abilities()->sync($ability, false);
    }

    public static function initValues() {
        if(Role::whereName('administrator')->first() == null) {
            $role = Role::create(['name' => 'administrator']);
            $abilities = Ability::all();
            foreach($abilities as $ability) {
                $role->allowTo($ability);
            }
        }

        if(Role::whereName('client')->first() == null) {
            $role = Role::create(['name' => 'client']);
            $availableAbilities = collect([
                Ability::whereName('read_client_profile')->firstOrFail(),
                Ability::whereName('write_client_profiles')->firstOrFail(),
                Ability::whereName('list_client_profiles')->firstOrFail(),
                Ability::whereName('change_client_status')->firstOrFail(),
                Ability::whereName('read_contract')->firstOrFail(),
                Ability::whereName('read_event_data')->firstOrFail(),
                Ability::whereName('read_situation_data')->firstOrFail(),
            ]);

            foreach($availableAbilities as $ability) {
                $role->allowTo($ability);
            }
        }

        if(Role::whereName('profile')->first() == null) {
            $role = Role::create(['name' => 'profile']);
            $availableAbilities = collect([
                Ability::whereName('read_client_profile')->firstOrFail(),
                Ability::whereName('write_client_profiles')->firstOrFail(),
                Ability::whereName('list_client_profiles')->firstOrFail(),
                Ability::whereName('change_client_status')->firstOrFail(),
                Ability::whereName('read_contract')->firstOrFail(),
                Ability::whereName('read_event_data')->firstOrFail(),
                Ability::whereName('read_situation_data')->firstOrFail(),
            ]);

            foreach($availableAbilities as $ability) {
                $role->allowTo($ability);
            }
        }

        if(Role::whereName('mentor')->first() == null) {
            $role = Role::create(['name' => 'mentor']);
            $availableAbilities = collect([
                Ability::whereName('read_client_profile')->firstOrFail(),
                Ability::whereName('list_client_profiles')->firstOrFail(),
                Ability::whereName('read_event_data')->firstOrFail(),
                Ability::whereName('read_situation_data')->firstOrFail(),
                Ability::whereName('read_session_data')->firstOrFail(),
                Ability::whereName('write_session_data')->firstOrFail(),
                Ability::whereName('manage_mentor_session')->firstOrFail(),


            ]);

            foreach($availableAbilities as $ability) {
                $role->allowTo($ability);
            }
        }


    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
