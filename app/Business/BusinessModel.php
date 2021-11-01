<?php


namespace App\Business;


use App\Attribute;
use App\AttributeGroup;
use App\Entity;
use App\Instance;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Parent class for all business models.
 * Class BusinessModel
 * @package App\Business
 */
class BusinessModel
{
    public $instance;

    public function __construct(Array $data = null)
    {
        if(isset($data['instance_id'])) {
            $this->instance = Instance::find($data['instance_id']);
        } else {
            $entity = $this->getEntity();
            $this->instance = Instance::create(['entity_id' => $entity->id]);
            $attributeIds = [];
            $attributes = static::getAttributesDefinition();
            foreach($attributes as $attribute) {
                $attributeIds[] = $attribute->id;
            }

            $this->instance->setAttributes($attributeIds);
            $this->setAttributes($data);
        }
    }

    public function getId() {
        return $this->instance->id;
    }

    /**
     * Saves the changes.
     */
    public function save() {
        $this->instance->save();
    }

    /**
     * Deletes the model.
     */
    public function delete() {
        $this->instance->delete();
    }

    /**
     * Gets the attribute values.
     * @param array|null $data (default null)
     * @return array
     */
    public function getData(array $data = null): array
    {

        // If the $data is null, return simply all.
        $attributeValues = $this->instance->getAttributeValues();
        $attributeValues['id'] = $this->instance->id;
        if(!$data) {
            return $attributeValues;
        }

        $attributeValues = [];
        foreach($data as $key) {
            if($key === 'id') {
                $attributeValues['id'] = $this->instance->id;
            } else {
                $attribute = $this->instance->attributes->where('name', $key)->first();
                $attributeValues[$attribute->name] = $attribute->getValue();
            }
        }

        return $attributeValues;
    }

    /**
     * Sets one or more attribute values.
     * @param $data array of input key=>value pairs.
     */
    public function setData($data) {
        if(!$data)
            return;

        foreach($data as $key => $value) {
            $attribute = $this->instance->attributes->where('name', $key)->first();
            if($attribute == null)
                continue;

            if($attribute->type === 'bool') {
                if($value === 'on' || $value === true)
                    $value = true;
                else
                    $value = false;
            }

            $attribute->setValue($value);
        }

    }

    /**
     * Shortcut for getting of the attribute value.
     * @param $attributeName
     * @return Attribute Value
     */
    public function getValue($attributeName) {
        $attribute = $this->getAttribute($attributeName);
        if($attribute == null)
            return null;

        return $attribute->getValue();
    }

    /**
     * Shortcut for getting of the attribute value
     * in textual (formatted) representation.
     * @param $attributeName
     * @return Attribute text
     */
    public function getText($attributeName) {
        $attribute = $this->getAttribute($attributeName);
        if($attribute == null)
            return null;

        return $attribute->getText();
    }

    /**
     * Shortcut for setting of the attribute text.
     * @param $attributeValue
     * @param $value
     * @return null
     */
    public function setValue($attributeValue, $value) {
        $attribute = $this->getAttribute($attributeValue);
        if($attribute == null)
            return null;

        return $attribute->setValue($value);
    }

    /**
     * Adds attribute to the instance of contract.
     * @param Attribute $attribute
     */
    public function addAttribute(Attribute $attribute) {
        $att = $this->instance->addAttribute($attribute);
        $this->instance->refresh();
        return $att;
    }

    /**
     * Adds the additional attributes to the instance.
     * @param $attributes
     * @param null $values
     */
    public function addExtraAttributes($attributes, $values=null) {
        $counter = 0;
        foreach ($attributes as $attribute) {
            if($this->getAttribute($attribute->name) == null) {
                $this->addAttribute($attribute);
            }

            $attr = $this->getAttribute($attribute->name);
            if($values != null && is_array($values) && isset($values[$counter])) {
                $attr->setValue($values[$counter]);
                $counter++;
            }
        }

    }

    /**
     * Removes attribute from this instance of contract.
     * @param Attribute $attribute
     */
    public function removeAttribute(Attribute $attribute) {
        $this->instance->removeAttribute($attribute);
        $this->instance->refresh();
    }

    /**
     * Returns the attributes collection for this instance.
     * @return mixed
     */
    public function getAttributes() {
        return $this->instance->attributes;
    }

    /**
     * Get attributes for the given attribute group.
     * @param $group
     * @return \Illuminate\Support\Collection
     */
    public function getAttributesForGroup($group): Collection
    {
        $groupAttributes = $group->attributes()->get();
        $clientAttributes = [];
        foreach($groupAttributes as $groupAttribute) {
            $clientAttribute = $this->getAttribute($groupAttribute->name);
            if($clientAttribute != NULL)
                $clientAttributes[] = $clientAttribute;
        }

        return collect($clientAttributes);
    }

    /**
     * Returns the attribute, which satisfies the query.
     * @param $query
     * @return mixed
     */
    public function getAttribute($query) {
        if(!is_array($query)) {
            return $this->getAttributes()->where('name', $query)->first();
        }

        return $this->getAttributes()->where($query)->first();
    }

    /**
     * Attaches user to the client.
     * @param $user
     */
    public function attachUser($user) {
        $this->instance->attachUser($user);
    }

    public function getUsers()
    {
        return $this->instance->users;
    }

    /**
     * Returns the attribute set for the creation form.
     * @return mixed
     */
    public function getInitialAttributes() {
        $initAttributesNamesCollection = $this->getInitAttributesNamesCollection();
        return $this->getAttributes()->whereIn('name', $initAttributesNamesCollection);
    }

    /**
     * Returns the textual interpretations of the attribute values.
     * @return array
     */
    public function getAttributeTexts() {
        $retval = [];
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            $retval[$attribute->label] = $attribute->getText();
        }
        $retval['id'] = $this->instance->id;

        return $retval;
    }

    /**
     * Checks if the business model contains
     * the attribute with the given name.
     * @param $attributeName
     * @return bool
     */
    public static function hasAttribute($attributeName): bool
    {
        $object = static::find()->first();
        if($object == null)
            return false;

        $attribute = Attribute::where('name', $attributeName)->first();
        if($attribute == null)
            return false;

        return $object->getAttributes()->contains($attribute);
    }

    /**
     * Gets the attibute from the collection of attributes or create the new one.
     * @param array $array
     * @return mixed
     */
    public static function selectOrCreateAttribute(Array $array) {
        $attribute = Attribute::where('name', $array[0])->first();
        if(!isset($attribute)) {
            if(isset($array[3])) {
                if(is_array($array[3])) {
                    $collection = collect($array[3]);
                    $attribute = Attribute::create(['name' => $array[0], 'label' => $array[1], 'type' => $array[2], 'extra' => $collection->toJson(), 'sort_order' => (isset($array[4]) ? $array[4] : 0)]);
                } else {
                    $attribute = Attribute::create(['name' => $array[0], 'label' => $array[1], 'type' => $array[2], 'extra' => $array[3], 'sort_order' => (isset($array[4]) ? $array[4] : 0)]);
                }
            } else {
                $attribute = Attribute::create(['name' => $array[0], 'label' => $array[1], 'type' => $array[2] ,'extra' => NULL,  'sort_order' => (isset($array[4]) ? $array[4] : 0) ]);
            }

        }

        return $attribute;
    }

    /**
     * Remove the attribute from entity and all its instances.
     * @param Attribute $attribute
     * @throws Exception
     */
    public static function removeOverallAttribute(Attribute $attribute) {

        // Remove attributes from all instances of the object.
        static::find()->each(function($object) use ($attribute) {

//            // Check for entity and delete attribute if contained.
//            $entity = $object->instance->entity;
//            if($entity->attributes->contains($attribute)) {
//                $entity->attributes()->detach($attribute);
//            }

            $object->removeAttribute($attribute);
        });

        // Delete attribute.
        $attribute->delete();
    }

    /**
     * Get the largest sorting order of the object attributes.
     */
    public static function getLastAttributeSortOrder() {
        $attributes = static::getAttributesDefinition();
        if(is_array($attributes))
            $attributes = collect($attributes);

        return $attributes->map(function($attribute) {
            return $attribute->sort_order;
        })->max();
    }

    /**
     * Adds new attribute to entity and all of its instances
     * and sets the default value if any.
     * @param Attribute $attribute
     * @param null $value
     */
    public static function addOverallAttribute(Attribute $attribute, $value=null) {
        static::find()->each(function($object) use($attribute, $value) {
            $object->addAttribute($attribute);
//            $entity = $object->instance->entity;
//            if(!$entity->attributes->contains($attribute)) {
//                $entity->attributes()->sync($attribute, false);
//            }

            if($value != null) {
                $objAttribute = $object->getAttribute($attribute->name);
                $objAttribute->setValue($value);
            }
        });
    }

    /**
     * Function that returns or creates (if ther is none) attribute group.
     * @param $groupName
     * @param null $groupLabel
     * @param null $sort_order
     */
    public static function getAttributeGroup($groupName, $groupLabel=null, $sort_order=null ) {
        $group = AttributeGroup::get($groupName);
        if($group == null) {
            $group = AttributeGroup::create(['name' => $groupName, 'label' => $groupLabel, 'sort_order' => $sort_order]);
        }

        return $group;
    }

    public static function getValidationParameters() {

    }

    /**
     * Search the object(s) in the database for the given criteria.
     * @param null $query
     * @return Instance[]|\Illuminate\Database\Eloquent\Collection|Collection|static|null
     */
    public static function find($query=null) {
        $tokens = explode("\\", static::class);
        if(count($tokens) == 0)
            return null;

        $className = $tokens[count($tokens) - 1];

        if(Entity::where('name', $className)->get()->count() == 0) {
            return isset($query) && is_string($query) ? null : collect([]);
        }

        // If it's empty.
        if(!isset($query)) {
            if(Entity::where('name', $className)->get()->count() == 0)
                return collect([]);

            $entity_id = Entity::where('name', $className)->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            return $instances->map(function($instance) {
                return new static(['instance_id' => $instance->id]);
            });
        }

        // If it's id.
        if(!is_array($query)) {
            $entity_id = Entity::whereName($className)->first()->id;
            if($entity_id == null)
                return null;
            $instance = Instance::where(['id' => $query, 'entity_id' => $entity_id])->first();
            if($instance == null)
                return null;

            return new static(['instance_id' => $instance->id]);
        }

        // If it's really array.
        foreach($query as $key => $value) {
            $attribute = Attribute::where('name', $key)->first();
            $tableName = $attribute->type.'_values';

            $entity_id = Entity::all()->where('name', $className)->first()->id;

            $temporary_results = DB::table($tableName)->select('instance_id')->where(['value' => $value, 'attribute_id' => $attribute->id])->get();
            $temporary_results = $temporary_results->map(function($item, $key) {
                return $item->instance_id;
            });

            $temporary_results = Instance::all()->whereIn('id', $temporary_results)->where('entity_id', $entity_id);

            if(!isset($results)) {
                $results = $temporary_results;
            } else {
                $results = $temporary_results->intersect($results);
            }

        }

        if($results->count() === 0) {
            return $results;
        }

        $objects = $results->map(function($result, $key) {
            return new static(['instance_id' => $result->id]);
        });

        return $objects;
    }

    public static function all() {
        return static::find();
    }

    public function getAttributeGroups() {}
    protected function getInitAttributesNamesCollection() {}
    protected function getEntity()  {}

    protected function setAttributes($data = null) {
        $this->setData($data);
    }


}
