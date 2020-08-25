<?php


namespace App\Business;


use App\Attribute;
use App\Entity;
use App\Instance;
use App\Value;
use Illuminate\Support\Facades\DB;

class Situation extends BusinessModel
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
            $entity_id = Entity::where('name', 'Situation')->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            foreach ($instances as $instance) {
                $events[] = new Situation(['instance_id' => $instance->id]);
            }

            return collect($events);
        }

        // If it's id.
        if(!is_array($query)) {
            $instance = Instance::find($query);
            return new Situation(['instance_id' => $instance->id]);
        }

        // If it's array.
        foreach($query as $key => $value) {

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

        $results_array = [];
        foreach ($results->get() as $item) {
            $event = new Situation(['instance_id' => $item->instance_id]);
            $results_array[] = $event;
        }

        return collect($results_array);
    }

    /**
     * Returns the short preview of the collection.
     * @return \Illuminate\Support\Collection
     */
    public static function all() {
        return Situation::find();
    }

    /**
     * Returns the collection of attributes typical for this type of instance.
     * @return array
     */
    public static function getAttributesDefinition()
    {
        $attributes = [];

        // Name of the event.
        $name = Attribute::where('name', 'name')->first();
        if(!$name) {
            $name = Attribute::create(['name' => 'name', 'label' => 'Naziv', 'type' => 'varchar']);
        }
        $attributes[] = $name;

        // What is it about?
        $description = Attribute::where('name', 'description')->first();
        if(!$description) {
            $description = Attribute::create(['name' => 'description', 'label' => 'Opis', 'type' => 'text']);
        }
        $attributes[] = $description;

        // Time of happening.
        $occurred_at = Attribute::where('name', 'occurred_at')->first();
        if(!$occurred_at) {
            $occurred_at = Attribute::create(['name' => 'occurred_at', 'label' => "Vreme dešavanja", 'type' => 'datetime']);
        }
        $attributes[] = $occurred_at;

        // Situation sender.
        $sender = Attribute::where('name', 'sender')->first();
        if(!$sender) {
            $sender = Attribute::create(['name' => 'sender', 'label' => 'Pošiljalac', 'type' => 'varchar']);
        }
        $attributes[] = $sender;

        return $attributes;

    }
        /**
     * Gets template.
     * @return mixed
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Situation')->first();
        if(!$entity) {
            $entity = Entity::create(['name' => 'Situation', 'description' => 'The data which will be connected to a specific event.']);

            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    /**
     * Initializes the attributes.
     */
    protected function setAttributes() {

        $this->instance->attributes->where('name', 'name')->first()->setValue(
            isset($this->data['name']) ? $this->data['name'] : 'Situation'
        );

        $this->instance->attributes->where('name', 'description')->first()->setValue(
            isset($this->data['description']) ? $this->data['description'] : ''
        );

        $this->instance->attributes->where('name', 'occurred_at')->first()->setValue(
            isset($this->data['occurred_at']) ? $this->data['occurred_at'] : now()
        );

        $this->instance->attributes->where('name', 'sender')->first()->setValue(
            isset($this->data['sender']) ? $this->data['sender'] : 'Unknown'
        );

    }

}
