<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user, $ability, $parameter) {
            if(!Auth::user()->isAdmin() && $ability === 'read_client_profile' && count($parameter) > 0) {
                $id = $parameter[0];
                $profile = Auth::user()->profile();

                if ($profile != null && $profile->getId() == $id)
                {
                    return true;
                }

            }

            else if(!Auth::user()->isAdmin() && $ability === 'read_program' && count($parameter) > 0) {
                $id = $parameter[0];
                $profile = Auth::user()->profile();
                $program = $profile->getActiveProgram();
                if($program != null && $program->getId() == $id) {
                    return true;
                }
            }
            else {
                return $user->abilities()->contains($ability);
            }
        });

    }
}
