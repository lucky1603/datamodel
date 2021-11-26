<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Ability::initValues();
        \App\Role::initValues();

        User::create([
            'name' => 'Sinisa Ristic',
            'email' => 'sinisa.ristic@gmail.com',
            'password' => Hash::make('NafNaf1603'),
            'position' => 'Super Administrator',
        ]);

        User::create([
            'name' => 'Nevena Jankovic',
            'email' => 'nevena.jankovic@ntpark.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Menadžer Programa',
        ]);

        User::create([
            'name' => 'Marijana BITF',
            'email' => 'marijana@bitf.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Menadžer Programa',
        ]);

        User::create([
            'name' => 'Jelena Petrović',
            'email' => 'jelena.petrovic@ntpark.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Ovlašćeno lice',
        ]);

        User::create([
            'name' => 'Jovana Vasić',
            'email' => 'jovana.vasic@bitf.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Ovlašćeno lice',
        ]);

        User::create([
            'name' => 'Bojan Milenković',
            'email' => 'bojan.milenkovic@ntpark.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Ovlašćeno lice',
        ]);

        User::create([
            'name' => 'IT',
            'email' => 'it@bitf.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Ovlašćeno lice',
        ]);

        User::create([
            'name' => 'Ivana Bezarević',
            'email' => 'ivana.bezarevic@ntpark.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Ovlašćeno lice',
        ]);

        User::create([
            'name' => 'Direktor',
            'email' => 'manager@ntpark.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Ovlašćeno lice',
        ]);

        User::create([
            'name' => 'Radiša Vičević',
            'email' => 'radisa.vicevic@ntpark.rs',
            'password' => Hash::make('NtPark1234'),
            'position' => 'Ovlašćeno lice',
        ]);

        User::all()->each(function($user) {
            $user->assignRole('administrator');
        });

    }
}
