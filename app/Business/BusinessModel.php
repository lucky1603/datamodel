<?php


namespace App\Business;


use App\Attribute;
use App\Instance;

/**
 * Parent class for all business models.
 * Class BusinessModel
 * @package App\Business
 */
class BusinessModel
{
    public $instance;
    protected $entity;
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
        if(isset($data['instance_id'])) {
            $this->instance = Instance::find($data['instance_id']);
        } else {
            $this->entity = $this->getEntity();
            $this->instance = Instance::create(['entity_id' => $this->entity->id]);
            $this->instance->getTemplateAttributes();
            $this->setAttributes();
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
     * Gets the attribute values.
     * @param array $data (default null)
     * @return array
     */
    public function getData($data = null) {

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
                if($value === 'on')
                    $value = true;
            }
            if(isset($attribute)) {
                $attribute->setValue($value);
            }
        }

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
     * Returns the textual interpretations of the attribute values.
     * @return array
     */
    public function getAttributeTexts() {
        $retval = [];
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            $retval[$attribute->name] = $attribute->getText();
        }
        $retval['id'] = $this->instance->id;

        return $retval;
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
                $attribute = Attribute::create(['name' => $array[0], 'label' => $array[1], 'type' => $array[2] , 'sort_order' => (isset($array[4]) ? $array[4] : 0) ]);
            }

        }

        return $attribute;
    }

    protected function getEntity() {}
    protected function setAttributes() {}

}
