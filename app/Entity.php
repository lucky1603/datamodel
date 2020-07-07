<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = ['name', 'description'];

    public function attributes() {
        return $this->belongsToMany(Attribute::class);
    }

    public function instances() {
        return $this->hasMany(Instance::class);
    }

    public function addAttribute(Attribute $attribute) {
        $this->attributes()->attach([$attribute->id]);
    }
}
