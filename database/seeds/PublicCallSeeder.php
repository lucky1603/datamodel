<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("public_calls")->delete();
        DB::statement("ALTER TABLE public_calls AUTO_INCREMENT = 0");
        
        $calls = [
            "Inkubacija", "Raising Starts", "Rastuće kompanije"
        ];

        foreach($calls as $call) {
            DB::table("public_calls")->insert([
                "name" => $call,
                "active" => false,
                "public_call_date" => null,
                "public_call_end_date" => null,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
    }
}
