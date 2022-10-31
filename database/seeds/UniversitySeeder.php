<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $universities = collect([
            __('Fakultet za fizičku hemiju UB'),
            __('Matematički fakultet UB'),
            __('Ekonomski fakultet UB'),
            __('Arhitektonski fakultet UB'),
            __('Fakultet za specijalnu edukaciju i rehabilitaciju UB'),
            __('Fakultet muzičke umetnosti UB'),
            __('Fizički fakultet UB'),
            __('Fakultet sporta i fizičkog vaspitanja UB'),
            __('Filološki fakultet UB'),
            __('Građevinski fakultet UB'),
            __('Medicinski fakultet UB'),
            __('Saobraćajni fakultet UB'),
            __('Biološki fakultet UB'),
            __('Fakultet veterinarske medicine UB'),
            __('Fakultet organizacionih nauka UB'),
            __('Filozofski fakultet UB'),
            __('Hemijski fakultet UB'),
            __('Pravni fakultet UB'),
            __('Stomatološki fakultet UB'),
            __('Učiteljski fakultet UB'),
            __('Vojna akademija UB'),
            __('Fakultet dramskih umetnosti UB'),
            __('Fakultet političkih nauka UB'),
            __('Mašinski fakultet UB'),
            __('Kriminalističko policijska akademija UB'),
            __('Pravoslavni bogoslovski fakultet UB'),
            __('Poljoprivredni fakultet UB'),
            __('Šumarski fakultet UB'),
            __('Vojnomedicinska akademija UB'),
            __('Elektrotehnički fakultet UB'),
            __('Fakultet likovnih umetnosti UB'),
            __('Fakultet primenjenih umetnosti UB'),
            __('Fakultet bezbednosti UB'),
            __('Farmaceutski fakultet UB'),
            __('Geografski fakultet UB'),
            __('Rudarsko-geološki fakultet UB'),
            __('Tehnološko-metalurški fakultet UB'),
            __('Univerzitet u Novom Sadu'),
            __('Univerzitet u Kragujevcu'),
            __('Univerzitet u Nišu'),
        ]);

        $universities->sort()->each(function($university) {
            DB::table('universities')
            ->updateOrInsert(
                ['name' => $university],
                ['name' => $university]
            );
        });

        DB::table('universities')->updateOrInsert(['name' => 'Drugo'], ['name' => 'Drugo']);

    }
}
