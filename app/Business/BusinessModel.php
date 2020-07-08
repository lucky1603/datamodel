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

    public function __construct($data)
    {
        $this->data = $data;
        $this->entity = $this->getEntity();
        if(isset($data['instance_id'])) {
            $this->instance = Instance::find($data['instance_id']);
        } else {
            $this->instance = Instance::create(['entity_id' => $this->entity->id, 'code' => $data['code']]);
            $this->instance->getTemplateAttributes();
            $this->setAttributes();
        }
    }

    /**
     * Gets back the contract code.
     * @return string
     */
    public function getCode() {
        return $this->instance->code;
    }

    public function getId() {
        return $this->instance->id;
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
            $attribute = $this->instance->attributes->where('name', 'key')->first();
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
            $attribute->setValue($value);
        }

    }

    /**
     * Adds attribute to the instance of contract.
     * @param Attribute $attribute
     */
    public function addAttribute(Attribute $attribute) {
        $this->instance->addAttribute($attribute);
    }

    /**
     * Removes attribute from this instance of contract.
     * @param Attribute $attribute
     */
    public function removeAttribute(Attribute $attribute) {
        $this->instance->removeAttribute($attribute);
    }

    protected function getEntity() {

    }


}
