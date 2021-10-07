<?php

namespace App\Business;

use App\Entity;
use Illuminate\Support\Collection;

class DemoDay extends BusinessModel implements Phase
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
                'demoday_date' => now(),
                'demoday_note' => __('gui.demoday_note'),
                'demoday_files' => null,
                'demoday_client_notified' => false,
                'demoday_files_sent' => false,
            ];
        }

        $this->setData($data);
    }

    /**
     * Returns the program to which this instance belongs.
     * @return Program|null
     */
    public function getProgram(): ?Program
    {
        $programInstance = $this->instance->parentInstances()->first();
        if($programInstance == null)
            return null;

        return new Program(0,['instance_id' => $programInstance->id]);
    }

    /**
     * Gets the attributes definitions of this instance.
     */
    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['demoday_date', __('Demo Day Date'), 'datetime', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['demoday_note', __('Demo Day Note'), 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['demoday_files', __('Demo Day Files'), 'file', 'multiple', 3]));
        $attributes->add(self::selectOrCreateAttribute(['demoday_client_notified', __('Demo Day Client Notified'), 'bool', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['demoday_files_sent', __('Demo Day Requested Files Sent'), 'bool', NULL, 5]));

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

    public function getUI(): string
    {
        return 'profiles.forms._demoday-form';
    }

    public function getAttributesData(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'id' => $this->getId(),
            'validStatus' => $this->getStatusValue(),
            'notified' => $this->getValue('demoday_client_notified')
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
}
