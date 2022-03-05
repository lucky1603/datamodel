<?php

namespace App\Business;

use App\Entity;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;

class DemoDay extends PhaseImpl
{
    private int $status = -1;

    /**
     * Gets the entity of the given instance.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'DemoDay')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'DemoDay', 'description' => __('Demo Day')]);
        }

        return $entity;
    }

    /**
     * Sets the default attribute values.
     * @param null $data
     */
    public function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'passed' => false,
            ];
        }

        $this->setData($data);
    }

    /**
     * Gets the attributes definitions of this instance.
     */
    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);
        $attributes->add(self::selectOrCreateAttribute(['passed', __('Passed'), 'bool', NULL, 1]));

        return $attributes;
    }


    public function getDisplayName()
    {
        return __('Demo Day');
    }

    public function getDisplayId(): string
    {
        return '#demoday';
    }

    public function getDisplayForm(): string
    {
        return 'profiles.forms._demoday-form';
    }

    public function getClientDisplayForm(): string
    {
        return 'profiles.forms._demoday_client-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->getStatusValue(),
            'notified' => $this->getValue('demoday_client_notified'),
            'model' => $this,
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

    public function isVisibleInHistory(): bool
    {
        return false;
    }

    public function requiresExitSituation(): bool
    {
        return true;
    }

    public function getExitSituation(): ?Situation
    {
        if($this->getValue('passed') == 'true') {
            return new Situation([
                'name' => 'Demo Day uspešno završen',
                'description' => 'Kandidat je uspešno ispunio sve uslove iz faze - demo day.',
                'sender' => 'NTP'
            ]);
        }

        return new Situation([
            'name' => 'Odbijen u fazi - Demo Day',
            'description' => 'Kandidat je odbijen u fazi - Demo Day.',
            'sender' => 'NTP'
        ]);
    }
}
