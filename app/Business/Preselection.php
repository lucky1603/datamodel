<?php

namespace App\Business;

use App\Entity;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;

class Preselection extends PhaseImpl
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
                'passed' => false,
                'note' => null,
                'date_of_session' => now(),
                'average_mark' => 0.0,
                'aditional_remark' => null
            ];
        }

        $this->setData($data);
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['passed', __('Passed'), 'bool', NULL, 1]));
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
            'validStatus' => $this->statusValue,
            'profile' => $this->getWorkflow()->getProgram()->getProfile()->getId()
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

    public function requiresEntryEmail()
    {
        return false;
    }

    public function getEntryEmailTemplate()
    {
        return null;
    }

    public function requiresEntrySituation(): bool
    {
        return false;
    }

    public function getEntrySituation() : ?Situation
    {
        return null;
    }

    public function requiresExitSituation(): bool
    {
        return false;
    }

    public function getExitSituation() : ?Situation
    {
        return null;
    }

    public function requiresExitEmail(): bool
    {
        return false;
    }

    public function getExitEmailTemplate() : ?Mailable
    {
        return null;
    }
}
