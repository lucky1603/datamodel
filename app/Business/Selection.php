<?php

namespace App\Business;

use App\Entity;
use \Illuminate\Support\Collection;

class Selection extends BusinessModel
{
    /**
     * Returns the attribute definition for this object.
     * @return \Illuminate\Support\Collection
     */
    private static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);
        $attributes->add(self::selectOrCreateAttribute(['selection_date', __('Selection Date'), 'datetime', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['meeting_notes', __("Notes from the Meeting"), 'text', NULL, 2]));

        $fulfillment_grade = self::selectOrCreateAttribute(['fulfillment_grade', __('Fulfillment Grade'), 'select', NULL, 3]);
        if(count($fulfillment_grade->getOptions()) == 0) {
            $fulfillment_grade->addOption(['value' => 1, 'text' => __('gui-select.FFG-Low')]);
            $fulfillment_grade->addOption(['value' => 2, 'text' => __('gui-select.FFG-Medium')]);
            $fulfillment_grade->addOption(['value' => 3, 'text' => __('gui-select.FFG-High')]);
        }

        $attributes->add($fulfillment_grade);

        $attributes->add(self::selectOrCreateAttribute(['average_mark_selection', __('Average Mark'), 'double', NULL, 4]));

        return $attributes;

    }

    /**
     * Gets the entity of this instance.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Selection')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Selection', 'description' => __('Final Selection')]);
            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    /**
     * Sets the attribute values. If data is null, set the default values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'meeting_notes' => null,
                'fulfillment_grade' => 0,
                'average_mark_selection' => 0.0,
                'selection_date' => null
            ];
        }

        $this->setData($data);
    }
}
