<?php

namespace App;

use App\Business\Client;
use App\Business\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'photo', 'position'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get assigned roles.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Assign user role.
     * @param $role
     */
    public function assignRole($role) {
        if(is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }

        $this->roles()->sync($role, false);
    }

    /**
     * Get all abilities assigned by the attached roles.
     */
    public function abilities() {
        return $this->roles->map->abilities->flatten()->pluck('name');
    }

    /**
     * Return the collection of all instances for this user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function instances() {
        return $this->belongsToMany(Instance::class)->withTimestamps();
    }

    /**
     * Checks whether the current user is administrator or not.
     * @return bool
     */
    public function isAdmin() {
        return $this->roles()->whereName('administrator')->count() != 0;
    }

    /**
     * Checks whether the current user has the particular role.
     * @param $role
     * @return bool
     */
    public function isRole($role) {
        return $this->roles()->whereName($role)->count() != 0;
    }


    public function client() {
        $instance = $this->instances()->first();
        return Client::find($instance->id);
    }

    public function profiles() {
        $profiles = $this->instances->filter(function($instance) {
            if($instance->entity->name == 'Profile')
                return true;
            return false;
        })->map(function($instance) {
            return new Profile(['instance_id' => $instance->id]);
        });

        return $profiles;
    }

    public function profile() {
        $profiles = $this->profiles();
        if($profiles == null)
            return $profiles;

        return $this->profiles()->first();
    }
}
