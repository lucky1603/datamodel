<?php

namespace App\Business;

use App\Entity;
use \Illuminate\Support\Collection;

class Session extends SituationsModel
{
    /**
     * Gets the program to which the session object belongs.
     * @return Program
     */
    public function getProgram() : Program {
        return $this->instance->parentInstances->filter(function ($instance) {
            if($instance->entity->name == 'Program')
                return true;
            return false;
        })->map(function ($instance) {
            return new Program(['instance_id' => $instance->id]);
        })->first();
    }

    /**
     * Return the methor who participates at the session.
     * @return Mentor
     */
    public function getMentor() : Mentor {
        return $this->instance->parentInstances->filter(function ($instance) {
            if($instance->entity->name == 'Mentor')
                return true;
            return false;
        })->map(function ($instance) {
            return new Mentor(['instance_id' => $instance->id]);
        })->first();
    }

    public function addAttendance(Attendance $attendance) {
        $program = $this->getProgram();

    }

    /**
     * Returns entity for this object.
     * @return Entity|void
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Session')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Session', 'description' => __('mentors Session')]);
            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    /**
     * Sets the default attribute values for this object type.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'session_name' => null,
                'session_description' => null,
                'session_start_date' => null,
                'session_start_time' => null,
                'session_duration' => 0,
                'duration_unit' => 0,
                'training_short_note' => null,
                'mentors_feedback' => null
            ];
        }

        $this->setData($data);
    }

    /**
     * Gets attributes definition for this object.
     * @return Collection
     */
    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['session_title', __('Session Title'), 'varchar', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['session_start_date', __('Beginning Date'), 'datetime', NULL, 3]));
        $attributes->add(self::selectOrCreateAttribute(['session_start_time', __('Beginning Time'), 'timestamp', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['session_duration', __('Session Duration'), 'integer', NULL, 5]));

        $duration = self::selectOrCreateAttribute(['session_duration_unit', __('Duration Unit'), 'select', NULL, 6]);
        if(count($duration->getOptions()) == 0) {
            $duration->addOption(['value' => 1, 'text' => 'min']);
            $duration->addOption(['value' => 2, 'text' => 'h']);
            $duration->addOption(['value' => 3, 'text' => 'd']);
        }

        $attributes->add($duration);

        $attributes->add(self::selectOrCreateAttribute(['session_short_note', 'Kratka beleška', 'text', NULL, 7]));
        $attributes->add(self::selectOrCreateAttribute(['has_mentor_feedback', __('Has Mentor\'s feedback'), 'bool', NULL, 8]));
        $attributes->add(self::selectOrCreateAttribute(['mentor_feedback', __('Mentor\'s Feedback'), 'text', NULL, 9]));
        $attributes->add(self::selectOrCreateAttribute(['has_client_feedback', __('Has Client\'s feedback'), 'bool', NULL, 10]));
        $attributes->add(self::selectOrCreateAttribute(['client_feedback', __('Mentor\'s Feedback'), 'text', NULL, 11]));

        return $attributes;
    }


}
