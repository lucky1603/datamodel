<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    protected $fillable = ['entity_id'];

    /**
     * Must be called after the constructor, in order
     * to get the template attributes.
     */
    public function getTemplateAttributes() {
        $entity = $this->entity()->first();
        $this->setAttributes($entity->attributes()->get());
        $this->initAttributes();
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
        $this->initAttributes();
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
        return $this->hasMany(Instance::class, 'parent_id');
    }

    /**
     * Gets the parent instance.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instance() {
        return $this->belongsTo(Instance::class, 'parent_id');
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
        foreach($this->attributes()->get() as $attribute) {
            if (Value::get($this, $attribute) == null) {
                switch ($attribute->type) {
                    case "varchar":
                        $value = "";
                        break;
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
                    default:
                        $value = false;
                        break;
                }
                Value::put($this->id, $attribute, $value);
            }
        }
    }
}
