<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = ['name', 'description'];

    public function attributes() {
        return $this->belongsToMany(Attribute::class);
    }

    public function attribute_groups() {
        return $this->belongsToMany(AttributeGroup::class);
    }

    public function instances() {
        return $this->hasMany(Instance::class);
    }

    public function addAttribute(Attribute $attribute) {
        $this->attributes()->sync($attribute, false);
    }

}
