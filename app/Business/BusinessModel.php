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
        $this->entity = $this->getEntity();
        if(isset($data['instance_id'])) {
            $this->instance = Instance::find($data['instance_id']);
        } else {
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
        if(!$data) {
            return $attributeValues;
        }

        $attributeValues = [];
        foreach($data as $key) {
            $attribute = $this->instance->attributes->where('name', $key)->first();
            $attributeValues[$attribute->name] = $attribute->getValue();
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
        $this->instance->addAttribute($attribute);
        $this->instance->refresh();
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
     * Returns the textual interpretations of the attribute values.
     * @return array
     */
    public function getAttributeTexts() {
        $retval = [];
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            $retval[$attribute->name] = $attribute->getText();
        }

        return $retval;
    }

    protected function getEntity() {}
    protected function setAttributes() {}

}
