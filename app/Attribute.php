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

    public function getValue() {
        if(isset($this->pivot)) {
            return Value::get($this->pivot->instance_id, $this);
        }
    }

    public function setValue($value) {
        if(isset($this->pivot)) {
            Value::put($this->pivot->instance_id, $this, $value);
        }
    }

    public function getOptions() {
        if($this->attribute_options->count() === 0)
            return [];

        $optionValues = [];
        foreach($this->attribute_options as $attribute_option) {
            $optionValues[$attribute_option->value] = $attribute_option->text;
        }

        return $optionValues;
    }

    public static function dump($query = null) {
        if(!$query) {
            $results = Attribute::all()->map(function($attribute) {
                return 'NAME:'.$attribute->name.' TYPE:'.$attribute->type.' LABEL:'.$attribute->label;
            });
        } else {
            $results = Attribute::where($query)->get()->map(function($attribute) {
                return 'NAME:'.$attribute->name.' TYPE:'.$attribute->type.' LABEL:'.$attribute->label;
            });
        }


        return $results;
    }
}
