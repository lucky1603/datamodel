<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Instance extends Model
{
    protected $fillable = ['entity_id'];

    /**
     * Must be called after the constructor, in order
     * to get the template attributes.
     */
    public function getTemplateAttributes() {
        $entity = $this->entity()->first();
        $attributes = $entity->attributes()->get();
        $this->setAttributes($attributes);

    }

    /**
     * Sets the parent instance if there is any.
     * @param Instance $instance
     * @param bool $save Do we want to save it immediatelly?
     */
    public function setParent(Instance $instance, $save = true) {
        $this->parent_id = $instance->id;
        if($save) {
            $this->save();
        }
    }

    /**
     * Attaches the new attributes collection to the existing ones.
     * @param $attributes
     */
    public function setAttributes($attributes) {
        $this->attributes()->attach($attributes);
    }

    /**
     * Returns the collection of belonging attributes.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes() {
        return $this->belongsToMany(Attribute::class)->withPivot('id');
    }

    /**
     * Adds single attribute to the collection of attributes.
     * @param Attribute $attribute
     */
    public function addAttribute(Attribute $attribute) {
        $this->attributes()->attach([$attribute->id]);
        return Attribute::find($attribute->id);
    }

    public function removeAttribute(Attribute $attribute)
    {
        $this->attributes()->detach([$attribute->id]);
    }

    /**
     * Returns the template.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    /**
     * Gets the collection of child instances.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instances() {
        return $this->belongsToMany(Instance::class, 'instance_to_instance', 'instance_id', 'related_instance_id');
    }

    /**
     * Gets the parent instance.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentInstances() {
        return $this->belongsToMany(Instance::class, 'instance_to_instance', 'related_instance_id', 'instance_id');
    }

    /**
     * Return the child instances whose data are presented as the array.
     * @return array
     */
    public function children() {
        $children = [];
        foreach($this->instances()->get() as $instance) {
            $childItem = [];
            $childItem['type'] = $instance->entity()->get()->first()->name;
            $childItem['id'] = $instance->id;
            $attributeValues = $instance->getAttributeValues();
            $children[$instance->id] = array_merge($childItem, $attributeValues);
        }

        return $children;
    }

    /**
     * Returns the array of attribute key-value pairs.
     * @return array
     */
    public function getAttributeValues() {
        $attributeValues = [];
        foreach ($this->attributes()->get() as $attribute) {
            $value = $attribute->getValue();
            $attributeValues[$attribute->name] = $value;
        }

        return $attributeValues;
    }

    /**
     * Initialize attributes with the default values.
     */
    public function initAttributes() {
        Log::debug('initAttributes started!');

        $this->attributes()->each(function($attribute, $index) {
            $current = microtime(true);
            switch ($attribute->type) {
                case "varchar":
                case "text":
                    $value = "";
                    break;
                case "datetime":
                    $value = now();
                    break;
                case 'integer':
                    $value = 0;
                    break;
                case 'double':
                    $value = 0.0;
                    break;
                case 'file':
                    $value = [
                        'filename' => '',
                        'filelink' => '',
                    ];
                    break;
                default:
                    $value = false;
                    break;
            }

            Value::put($this->id, $attribute, $value);
            $current = microtime(true) - $current;
            Log::debug('Value of attribute = '.$attribute->name. ' set in '. $current. ' seconds.');
        });

        Log::debug('initAttributes ended!');
    }

    /**
     * Return all users of this instance.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Attaches user to the instance.
     * @param $user
     */
    public function attachUser($user) {
        $this->users()->sync($user, false);
    }
}
