<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'label', 'type'];

    public function entities() {
        return $this->belongsToMany(Entity::class);
    }

    public function instances() {
        return $this->belongsToMany(Instance::class)->withPivot('id');
    }

    public function attribute_options() {
        return $this->hasMany(AttributeOption::class);
    }
}
