<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = [];

    public function company_stats() {
        return $this->belongsToMany(CompanyStat::class);
    }
}
