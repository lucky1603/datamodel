<?php

namespace App\Business;

use App\Entity;

class Faza1 extends BusinessModel implements Phase
{

    private int $status = -1;

    public function getEntity()
    {
        $entity = Entity::where('name', 'Phase1')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Phase1', 'description' => __('Phase 1')]);
        }

        return $entity;
    }

    public function getDisplayName()
    {
        return __('Phase 1');
    }

    public function getDisplayId(): string
    {
        return '#phase1';
    }

    public function getDisplayForm(): string
    {
        return 'profiles.forms._phase1-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->getStatusValue()
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

    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'has_passed' => false,
                'short_note' => null,
                'requested_files' => null,
            ];
        }

        $this->setData($data);
    }

    public static function getAttributesDefinition(): \Illuminate\Support\Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['has_passed', __('Had Passed'), 'bool', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['short_note', __('Short Note'), 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['requested_files', __('Requested Files'), 'file', 'multiple', 3]));

        return $attributes;
    }
}
