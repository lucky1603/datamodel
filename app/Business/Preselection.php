<?php

namespace App\Business;

use App\Entity;

class Preselection extends BusinessModel
{
    /**
     * Gets the entity template.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Preselection')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Preselection', 'description' => __('Preselection')]);
            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    /**
     * Sets the attributes either with data or with the default values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'condition_met' => false,
                'note' => null,
                'date_of_session' => now(),
                'average_mark' => 0.0,
                'aditional_remark' => null
            ];
        }

        $this->setData($data);
    }

    /**
     * Returns the program the preselection belongs to.
     * @return Program|null
     */
    public function getProgram(): ?Program
    {
        $programInstance = $this->instance->parentInstances()->first();
        if($programInstance == null)
            return null;

        return new Program(0,['instance_id' => $programInstance->id]);
    }

    public static function getAttributesDefinition() {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['conditions_met', __('Conditions Met'), 'bool', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['note', __('Note'), 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['date_of_session', __('Date of Session'), 'datetime', NULL, 3]));
        $attributes->add(self::selectOrCreateAttribute(['average_mark', __('Average Mark'), 'double', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['additional_remark', __('Aditional Remark'), 'text', NULL, 5]));

        return $attributes;
    }


}
