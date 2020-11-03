<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'label', 'type', 'extra', 'sort_order'];

    // ORM things.

    /**
     * Get entities that contain this attribute.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function entities() {
        return $this->belongsToMany(Entity::class);
    }

    /**
     * Get instances that contain this attribute.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function instances() {
        return $this->belongsToMany(Instance::class)->withPivot('id');
    }

    /**
     * Get attribute option files, if the attribute is of type 'select'.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attribute_options() {
        return $this->hasMany(AttributeOption::class);
    }

    /**
     * List groups the attribute belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attribute_groups() {
        return $this->belongsToMany(AttributeGroup::class);
    }

    // Methods.

    /**
     * Add attribute to group.
     * @param $group
     */
    public function addToGroup($group) {
        $this->attribute_groups()->sync($group, false);
    }

    /**
     * Gets attribute value in the context of the containing instance.
     * @return array|mixed|null
     */
    public function getValue() {
        if(isset($this->pivot)) {
            return Value::get($this->pivot->instance_id, $this);
        }
    }

    /**
     * Return textual version of the value.
     * @return string|null
     */
    public function getText() {
        $value = $this->getValue();
        if(!isset($value))
            return null;

        if($this->type === 'select') {
            $returnText = '';
            if(is_array($value)) {
                foreach ($value as $key) {
                    $option = $this->attribute_options->where('value', $key)->first();
                    if(strlen($returnText) > 0) {
                        $returnText = $returnText.';';
                    }

                    $returnText = $returnText.' '.$option->text;
                }
            } else {
                $option = $this->attribute_options->where('value', $value)->first();
                $returnText = $option != null ? $option->text : $value;
            }

            return $returnText;
        } else if ($this->type === 'bool') {
            return $value === false ? 'ne' : 'da';
        } else if ($this->type === 'file') {
            return isset($value['filename']) ? $value['filename'] : '';
        } else
        {
            return strval($value);
        }
    }

    /**
     * Sets the attribute value in the context of the given instance.
     * @param $value
     */
    public function setValue($value) {
        if(isset($this->pivot)) {
            Value::put($this->pivot->instance_id, $this, $value);
        }
    }

    /**
     * Gets the array of option values if the attribute is of 'select' type.
     * @return array
     */
    public function getOptions() {
        if($this->attribute_options->count() === 0)
            return [];

        $optionValues = [];
        foreach($this->attribute_options as $attribute_option) {
            $optionValues[$attribute_option->value] = $attribute_option->text;
        }

        return $optionValues;
    }

    /**
     * Adds the single option.
     * @param array $optionProperties
     */
    public function addOption(Array $option) {
        $this->attribute_options()->create($option);
        $this->refresh();
    }

    /**
     * Adds the options as bulk.
     * Sets the options array, reseting the existing content.
     * @param array $options
     */
    public function setOptions(Array $options) {

        // Delete the current options.
        $this->deleteOptions();

        foreach($options as $key => $value) {
            $this->attribute_options()->create([
                'value' => $key,
                'text' => $value
            ]);
        }

        $this->refresh();
    }

    /**
     * Delete the current options from the database.
     */
    public function deleteOptions() {
        // Delete existing options.
        $this->attribute_options->each(function($item, $key) {
            return $item->delete();
        });

        $this->refresh();
    }

    /**
     * Dumps the previes of all attributes in the database.
     * @param null $query
     * @return Attribute[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
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
