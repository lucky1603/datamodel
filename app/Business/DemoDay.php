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

//        $attributes->add(self::selectOrCreateAttribute(['demoday_date', __('Demo Day Date'), 'datetime', NULL, 1]));
//        $attributes->add(self::selectOrCreateAttribute(['demoday_note', __('Demo Day Note'), 'text', NULL, 2]));
//        $attributes->add(self::selectOrCreateAttribute(['demoday_files', __('Demo Day Files'), 'file', 'multiple', 3]));
//        $attributes->add(self::selectOrCreateAttribute(['demoday_client_notified', __('Demo Day Client Notified'), 'bool', NULL, 4]));
//        $attributes->add(self::selectOrCreateAttribute(['demoday_files_sent', __('Demo Day Requested Files Sent'), 'bool', NULL, 5]));

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

    public function isVisibleInHistory(): bool
    {
        return false;
    }
}
