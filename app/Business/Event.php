<?php


namespace App\Business;


use App\Attribute;
use App\Entity;
use App\Instance;
use App\Value;
use Illuminate\Support\Facades\DB;

class Event extends BusinessModel
{


    /**
     * Removes the element instance from the database.
     */
    public function delete() {
        $this->instance->delete();
    }

    /**
     * Search the database for a contract the given criteria.
     * @param $query Array of key/value pairs.
     * @return Contract|\Illuminate\Support\Collection
     */
    public static function find($query=null) {

        // If it's empty.
        if(!isset($query)) {
            $contracts = [];
            $entity_id = Entity::where('name', 'Event')->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            foreach ($instances as $instance) {
                $events[] = new Event(['instance_id' => $instance->id]);
            }

            return collect($events);
        }

        // If it's id.
        if(!is_array($query)) {
            $instance = Instance::find($query);
            return new Event(['instance_id' => $instance->id]);
        }

        // If it's array.
        foreach($query as $key => $value) {
            if($key === 'code') {
                $instance = Instance::where('code', $value)->first();
                if($instance->entity->name === 'Event') {
                    return new Event(['instance_id' => $instance->id]);
                } else
                    return null;
            } else {
                $attribute = Attribute::where('name', $key)->first();
                $tableName = $attribute->type.'_values';
                $temporary_results = DB::table($tableName)->select('instance_id')->where(['value' => $value, 'attribute_id' => $attribute->id]);
                if(!isset($results)) {
                    $results = $temporary_results;
                } else {
                    $results = $temporary_results->intersect($temporary_results);
                }

                if($results->count() === 0) {
                    return $results->get();
                }

            }
        }

        $results_array = [];
        foreach ($results->get() as $item) {
            $event = new Event(['instance_id' => $item->instance_id]);
            $results_array[] = $event;
        }

        return collect($results_array);
    }


    /**
     * Returns the short preview of the collection.
     * @return \Illuminate\Support\Collection
     */
    public static function all() {
        return Event::find()->map(function($event) {
            return $event->instance->id.'-'.$event->instance->code;
        });
    }
        /**
     * Gets template.
     * @return mixed
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Event')->first();
        if(!$entity) {
            $entity = Entity::create(['name' => 'Event', 'description' => 'The data which will be connected to a specific event.']);

            // Name of the event.
            $name = Attribute::where('name', 'name')->first();
            if(!$name) {
                Attribute::create(['name' => 'name', 'label' => 'Naziv', 'type' => 'varchar']);
            }
            $entity->addAttribute($name);

            // What is it about?
            $description = Attribute::where('name', 'description')->first();
            if(!$description) {
                Attribute::create(['name' => 'description', 'label' => 'Opis', 'type' => 'text']);
            }
            $entity->addAttribute($description);

            // Time of happening.
            $occurred_at = Attribute::where('name', 'occurred_at')->first();
            if(!$occurred_at) {
                $occurred_at = Attribute::create(['name' => 'occurred_at', 'label' => "Vreme dešavanja", 'type' => 'datetime']);
            }
            $entity->addAttribute($occurred_at);

            // Event sender.
            $sender = Attribute::where('name', 'sender')->first();
            if(!$sender) {
                $sender = Attribute::create(['name' => 'sender', 'label' => 'Pošiljalac', 'type' => 'varchar']);
            }
            $entity->addAttribute($sender);
        }

        return $entity;
    }

    /**
     * Initializes the attributes.
     */
    protected function setAttributes() {

        $this->instance->attributes->where('name', 'name')->first()->setValue(
            isset($this->data['name']) ? $this->data['name'] : 'Event'
        );

        $this->instance->attributes->where('name', 'description')->first()->setValue(
            isset($this->data['description']) ? $this->data['description'] : 'Event description'
        );

        $this->instance->attributes->where('name', 'occurred_at')->first()->setValue(
            isset($this->data['occurred_at']) ? $this->data['occurred_at'] : now()
        );

        $this->instance->attributes->where('name', 'sender')->first()->setValue(
            isset($this->instance->instance) ?
                $this->instance->instance->entity->name.'-'.$this->instance->instance->code : "Unknown"
        );

    }

}
