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
            return new Program(0, ['instance_id' => $instance->id]);
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

    /**
     * Returns entity for this object.
     * @return Entity|void
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Session')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Session', 'description' => __('mentors Session')]);
        }

        return $entity;
    }

    /**
     * Reveals if there is client feedback or not.
     * @return bool
     */
    public function hasClientFeedback(): bool
    {
        if($this->getValue('client_feedback') == null || strlen($this->getValue('client_feedback')) == 0)
            return false;
        return true;
    }

    /**
     * Reveals if there is mentors feedback or not.
     * @return bool
     */
    public function hasMentorFeedback(): bool
    {
        if($this->getValue('mentor_feedback') == null || strlen($this->getValue('mentor_feedback')) == 0)
            return false;
        return true;
    }

    public function isFinished() {
        return $this->getValue('session_is_finished');
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
                'session_duration_unit' => 0,
                'session_short_note' => null,
                'mentors_feedback' => null,
                'client_feedback' => null,
                'session_is_finished' => false
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

        $attributes->add(self::selectOrCreateAttribute(['session_short_note', __('Short Note'), 'text', NULL, 7]));

        $attendance = self::selectOrCreateAttribute(['session_client_attendance', __('Client Attandance at Session'), 'select', NULL, 8]);
        if(count($attendance->getOptions()) == 0) {
            $attendance->addOption(['value' => 1, 'text' => __('Pre-session')]);
            $attendance->addOption(['value' => 2, 'text' => __('Present')]);
            $attendance->addOption(['value' => 3, 'text' => __('Didn\'t show up')]);
        }
        $attributes->add($attendance);

        $attributes->add(self::selectOrCreateAttribute(['mentor_feedback', __("Mentor's Feedback"), 'text', NULL, 9]));
        $attributes->add(self::selectOrCreateAttribute(['client_feedback', __("Client's Feedback"), 'text', NULL, 10]));
        $attributes->add(self::selectOrCreateAttribute(['session_is_finished', __('Is Session Finished'), 'bool', NULl, 11]));

        return $attributes;
    }


}
