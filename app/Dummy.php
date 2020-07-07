<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    protected $fillable = ['name'];

    public function dummies() {
        return $this->hasMany(Dummy::class, 'parent_id');
    }

    public function dummy() {
        return $this->belongsTo(Dummy::class, 'parent_id');
    }
}
