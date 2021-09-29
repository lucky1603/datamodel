<?php

namespace App\Business;

use App\Entity;
use Illuminate\Support\Collection;

class Attendance extends BusinessModel
{

    /**
     * Fetches the program.
     * @return Program|null
     */
    public function getProgram(): ?Program
    {
        return $this->instance->parentInstances->filter(function($instance) {
            if($instance->entity->name == 'Program')
                return true;
            return false;
        })->map(function($instance) {
            return new Program(0, ['instance_id' => $instance->id]);
        })->first();
    }

    /**
     * Fetches the training.
     * @return Training|null
     */
    public function getTraining(): ?Training
    {
        return $this->instance->parentInstances->filter(function($instance) {
            if($instance->entity->name == 'Training')
                return true;
            return false;
        })->map(function($instance) {
            return new Training(['instance_id' => $instance->id]);
        })->first();
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
            $entity = Entity::create(['name' => 'Attendance', 'description' => __('Attendance at Training')]);
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
