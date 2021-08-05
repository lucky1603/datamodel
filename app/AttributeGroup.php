<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $guarded = [];

    public function attributes() {
        return $this->belongsToMany(Attribute::class);
    }

    public function entities() {
        return $this->belongsToMany(Entity::class);
    }

    public function addAttribute($attribute) {
        $this->attributes()->sync($attribute, false);
        return $attribute;
    }

    public static function get($attributeName) {
        return AttributeGroup::whereName($attributeName)->first();
    }

//    public function getAttributes() {
//        return $this->attributes()->get()->sortBy('sort_order');
//    }
}
