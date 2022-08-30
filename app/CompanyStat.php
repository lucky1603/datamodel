<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyStat extends Model
{
    protected $guarded = [];

    public function reports() {
        return $this->hasMany(Report::class);
    }

    public function countries() {
        return $this->belongsToMany(Country::class);
    }
}
