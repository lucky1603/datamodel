<?php

use App\Imports\CountriesImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("countries")->delete();
        DB::statement("ALTER TABLE countries AUTO_INCREMENT = 0");
        
        Excel::import(new CountriesImport, 'countries.xlsx', 'public');
    }
}
