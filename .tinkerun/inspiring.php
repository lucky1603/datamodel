<?php

use Illuminate\Support\Facades\DB;




DB::table('program_caches')
    ->selectRaw('ntp_text as ntp, COUNT(ntp) as count')
    ->where([
        'program_type' => 2,
        'year' => 2024,
    ])
    ->whereNotIn('program_status', [0,-5])
    ->groupBy(['ntp', 'ntp_text'])
    ->get()
    ->toArray();
