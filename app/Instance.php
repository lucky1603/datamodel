<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instance extends Model
{
    protected $fillable = ['entity_id'];

    /**
     *
     * @return BelongsToMany
     */
    public function attribute_groups() {
        return $this->belongsToMany(AttributeGroup::class);
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
     * @return BelongsToMany
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
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function mentor_reports(): HasMany
    {
        if($this->entity->name === 'Mentor')
            return $this->hasMany(MentorReport::class, 'mentor_id');
        return $this->hasMany(MentorReport::class, 'program_id');
    }

    /**
     * Attaches user to the instance.
     * @param $user
     */
    public function attachUser($user) {
        $this->users()->sync($user, false);
    }

    /**
     * Returns the array of attribute key-value pairs.
     * @return array
     */
    public function getAttributeValues($data = null): array
    {
        $attributeValues = [];
        if(isset($data)) {
            $attributes = $this->attributes()->whereIn('name', $data)->get();
        } else {
            $attributes = $this->attributes()->get();
        }
        foreach ($attributes as $attribute) {
            $value = $attribute->getValue();
            $attributeValues[$attribute->name] = $value;
        }

        return $attributeValues;
    }
}
