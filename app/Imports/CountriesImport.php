<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class CountriesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $counter = 0;
        foreach ($collection as $country) {             
            if($counter > 0) {
                var_dump($country[1]." - ".$country[2]);
                DB::table("countries")->insert([
                    "code"=> $country[1],
                    "country"=> $country[2]
                ]);
            }

            $counter++;            
        }
    }
}
