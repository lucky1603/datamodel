<?php

namespace App\Business;

use App\Entity;
use \Illuminate\Support\Collection;

class Selection extends PhaseImpl
{
    private int $status = -1;
    /**
     * Returns the attribute definition for this object.
     * @return \Illuminate\Support\Collection
     */
    public static function getAttributesDefinition(): Collection
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
        $attributes->add(self::selectOrCreateAttribute(['passed', __('Passed'), 'bool', NULL, 5]));

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
    /**
     * Gets the associated program.
     * @return Program|null
     */
    public function getProgram(): ?Program
    {
        $programInstance = $this->instance->parentInstances()->first();
        if($programInstance == null)
            return null;

        return ProgramFactory::resolve($programInstance->id);
    }

    public function getDisplayName()
    {
        return __('Selection');
    }

    public function getDisplayId(): string
    {
        return '#selection';
    }

    public function getDisplayForm(): string
    {
        return 'profiles.forms._selection-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->getStatusValue(),
            'profile' => $this->getWorkflow()->getProgram()->getProfile()->getId()
        ];
    }

    public function getStatusValue(): int
    {
        return $this->status;
    }

    public function setStatusValue($value)
    {
        $this->status = $value;
    }

    public function requiresEntryEmail()
    {
        return false;
    }

    public function getEntryEmailTemplate()
    {
        return null;
    }

    public function requiresEntrySituation()
    {
        // TODO: Implement requiresEntrySituation() method.
    }

    public function getEntrySituation()
    {
        // TODO: Implement getEntrySituation() method.
    }

    public function requiresExitSituation()
    {
        // TODO: Implement requiresExitSituation() method.
    }

    public function getExitSituation()
    {
        // TODO: Implement getExitSituation() method.
    }

    public function requiresExitEmail()
    {
        // TODO: Implement requiresExitEmail() method.
    }

    public function getExitEmailTemplate()
    {
        // TODO: Implement getExitEmailTemplate() method.
    }
}
