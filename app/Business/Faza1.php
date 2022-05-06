<?php

namespace App\Business;

use App\Entity;
use Illuminate\Mail\Mailable;

class Faza1 extends PhaseImpl
{

    private int $status = -1;

    public function getEntity()
    {
        $entity = Entity::where('name', 'Faza1')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Faza1', 'description' => __('Faza 1')]);
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
        return 'profiles.forms._faza1-form';
    }

    public function getClientDisplayForm(): string
    {
        return 'profiles.forms._faza1_client-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->getStatusValue(),
            'program' => $this->getWorkflow()->getProgram(),
            'phase' => $this
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
                'passed' => false,
                'short_note' => null,
                'requested_files' => null,
                'due_date' => null,
            ];
        }

        $this->setData($data);
    }

    public static function getAttributesDefinition(): \Illuminate\Support\Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['passed', __('Passed'), 'bool', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['short_note', __('Short Note'), 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['requested_files', __('Requested Files'), 'file', 'multiple', 3]));
        $attributes->add(self::selectOrCreateAttribute(['due_date', __('Due Date'), 'datetime', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['files_sent', __('Files Sent'), 'bool', NULL, 5]));

        return $attributes;
    }

    public function isValid(): bool
    {
        return ($this->getValue('due_date') != null && $this->getValue('files_sent') == true);
    }

    public function requiresExitSituation(): bool
    {
        return true;
    }

    public function getExitSituation(): ?Situation
    {
        if($this->getValue('passed') == 'true') {
            return new Situation([
                'name' => 'Faza 1 uspešno završena',
                'description' => 'Kandidat je uspešno ispunio sve uslove iz faze 1.',
                'sender' => 'NTP'
            ]);
        }

        return new Situation([
            'name' => 'Odbijen u Fazi 1',
            'description' => 'Kandidat je odbijen u Fazi 1',
            'sender' => 'NTP'
        ]);
    }
}
