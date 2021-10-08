<?php

namespace App\Business;

use App\Entity;
use Illuminate\Support\Collection;

class Preselection extends BusinessModel implements Phase
{
    private int $statusValue = -1;

    /**
     * Gets the entity template.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Preselection')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Preselection', 'description' => __('Preselection')]);
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

        return ProgramFactory::resolve($programInstance->id);
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['conditions_met', __('Conditions Met'), 'bool', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['note', __('Note'), 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['date_of_session', __('Date of Session'), 'datetime', NULL, 3]));
        $attributes->add(self::selectOrCreateAttribute(['average_mark', __('Average Mark'), 'double', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['additional_remark', __('Aditional Remark'), 'text', NULL, 5]));

        return $attributes;
    }


    public function getDisplayName()
    {
        return __('Preselection');
    }

    public function getDisplayId(): string
    {
        return '#preselection';
    }

    public function getDisplayForm(): string
    {
        return 'profiles.forms._preselection-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->statusValue
        ];
    }

    public function getStatusValue(): int
    {
        return $this->statusValue;
    }

    public function setStatusValue($value)
    {
        $this->statusValue = $value;
    }
}
