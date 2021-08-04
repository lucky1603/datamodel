<?php

namespace App\Business;

class SituationsModel extends BusinessModel
{
    /**
     * Gets the collection of belonging events.
     * @return mixed
     */
    public function getSituations() {
        $situations = [];
        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Situation' ) {
                $situations[] = new Situation(['instance_id' => $instance->id]);
            }
        }

        return collect($situations);
    }

    /**
     * Get situation with given key.
     * @param $key
     * @return mixed
     */
    public function getSituation($key) {
        return Situation::find(['name' => $key])->filter(function($item, $key) {
            $parent = $item->instance->parentInstances->first();
            if($parent != null && $parent->id == $this->instance->id)
                return $item;
        })->first();

    }

    /**
     * Return events in the form of an array.
     * @return mixed
     */
    public function getSituationsData() {
        $results = [];
        $situations = $this->getSituations();
        foreach($situations as $situation) {
            $results[$situation->getId()] = $situation->getData();
        }

        return $results;
    }

    /**
     * Adds event to contract.
     * @param Situation $situation
     */
    public function addSituation(Situation $situation): Situation
    {
        $this->instance->instances()->save($situation->instance);
        $this->instance->refresh();
        return $situation;
    }

    public function addSituationByData($situationType, $params) {}
}
