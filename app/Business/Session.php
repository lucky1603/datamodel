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
        return $this->instance->parent_instances()->filter(function ($instance) {
            if($instance->entity->name == 'Program')
                return true;
        })->map(function ($instance) {
            return new Program(['instance_id' => $instance->id]);
        })->first();
    }

    /**
     * Return the methor who participates at the session.
     * @return Menthor
     */
    public function getMenthor() : Menthor {
        return $this->instance->parent_instances()->filter(function ($instance) {
            if($instance->entity->name == 'Menthor')
                return true;
        })->map(function ($instance) {
            return new Program(['instance_id' => $instance->id]);
        })->first();
    }

    /**
     * Returns the attendance of the participating program.
     * @return mixed
     */
    public function getAttendance() {
        return $this->instance->instances()->filter(function ($instance) {
            if($instance->entity->name == 'Attendance')
                return true;
        })->map(function ($instance) {
            return new Attendance(['instance_id' => $instance->id]);
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
            $entity = new Entity(['name' => 'Session', 'description' => __('Menthors Session')]);
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
                'menthors_feedback' => null
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

        $attributes->add(self::selectOrCreateAttribute(['session_name', __('Session Name'), 'varchar', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['session_description', __('Session Description'), 'text', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['session_start_date', __('Beginning Date'), 'datetime', NULL, 3]));
        $attributes->add(self::selectOrCreateAttribute(['session_start_time', __('Beginning Time'), 'timestamp', NULL, 4]));
        $attributes->add(self::selectOrCreateAttribute(['session_duration', __('Session Duration'), 'integer', NULL, 5]));

        $duration = self::selectOrCreateAttribute(['duration_unit', __('Duration Unit'), 'select', NULL, 6]);
        if(count($duration->getOptions()) == 0) {
            $duration->addOption(['value' => 1, 'text' => 'min']);
            $duration->addOption(['value' => 2, 'text' => 'h']);
            $duration->addOption(['value' => 3, 'text' => 'd']);
        }

        $attributes->add($duration);

        $attributes->add(self::selectOrCreateAttribute(['training_short_note', 'Kratka beleška', 'text', NULL, 7]));
        $attributes->add(self::selectOrCreateAttribute(['menthors_feedback', __('Menthor\'s Feedback'), 'text', NULL, 8]));

        return $attributes;
    }


}
