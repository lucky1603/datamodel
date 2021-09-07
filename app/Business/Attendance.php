<?php

namespace App\Business;

use Illuminate\Support\Collection;

class Attendance extends BusinessModel
{

    /**
     * Fetches the program.
     * @return Program|null
     */
    public function getProgram(): ?Program
    {
        $entityId = Entity::where('name', 'Program')->first();
        $profileInstance = $this->instance->parentInstances()->where('entity_id', $entityId)->first();
        if($profileInstance == null)
            return null;

        return new Program(['instance_id' => $profileInstance->id]);
    }

    /**
     * Fetches the training.
     * @return Training|null
     */
    public function getTraining(): ?Training
    {
        $entityId = Entity::where('name', 'Training')->first();
        $trainingInstance = $this->instance->parentInstances()->where('entity_id', $entityId)->first();
        if($trainingInstance == null)
            return null;

        return new Training(['instance_id' => $trainingInstance->id]);
    }

    /**
     * Fetches the session.
     * @return Session|null
     */
    public function getSession(): ?Session
    {
        $entityId = Entity::where('name', 'Session')->first();
        $trainingInstance = $this->instance->parentInstances()->where('entity_id', $entityId)->first();
        if($trainingInstance == null)
            return null;

        return new Session(['instance_id' => $trainingInstance->id]);
    }

    /**
     * Returns the parent entity.
     * @return Entity|void
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Attendance')->first();
        if($entity == null) {
            $entity = new Entity(['name' => 'Attendance', 'description' => __('Attendance at Training')]);

            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    /**
     * Sets the default attributes.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'attendance' => 0,
                'has_client_feedback' => false,
                'clent_feedback' => null,
            ];
        }

        $this->setData($data);
    }

    /**
     * Gets the attributes definition.
     * @return Collection
     */
    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attendance = self::selectOrCreateAttribute(['attendance', 'Pristustvo', 'select', NULL, 1]);
        if(count($attendance->getOptions()) == 0) {
            $attendance->addOption(['value' => 1, 'text' => __('Notified')]);
            $attendance->addOption(['value' => 2, 'text' => __('Showed Up')]);
            $attendance->addOption(['value' => 3, 'text' => __('Didn\'t show up')]);
        }
        $attributes->add($attendance);

        $attributes->add(self::selectOrCreateAttribute(['has_client_feedback', __('Has Client Feedback'), 'bool', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['client_feedback', __('Client Feedback'), 'text', NULL, 3]));

        return $attributes;
    }
}
