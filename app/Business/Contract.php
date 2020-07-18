<?php


namespace App\Business;

use App\Attribute;
use App\Entity;
use App\Instance;
use App\Value;
use Illuminate\Support\Facades\DB;

class Contract extends BusinessModel
{
    /**
     * Gets the collection of belonging events.
     * @return mixed
     */
    public function getEvents() {
        $events = [];
        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Event' && $instance->instance->entity->name === 'Contract') {
                $events[] = new Event(['instance_id' => $instance->id]);
            }
        }

        return collect($events);
    }

    /**
     * Return events in the form of an array.
     * @return mixed
     */
    public function getEventsData() {
        $results = [];
        $events = $this->getEvents();
        foreach($events as $event) {
            $results[$event->getId()] = $event->getData();
        }

        return $results;
    }

    /**
     * Adds event to contract.
     * @param Event $event
     */
    public function addEvent(Event $event) {
        $this->instance->instances()->save($event->instance);
        $this->instance->refresh();
    }

    public function addEventByData($eventType, $params = null) {

        $data = [];
        switch($eventType) {
            case 'prva_rata':
                $event = new Event();
                $amount = Attribute::where('name', 'amount')->first();
                if(!$amount) {
                    $amount = Attribute::create(['name' => 'amount', 'label' => 'Iznos', 'type' => 'double']);
                }
                $event->addAttribute($amount);

                $currency = Attribute::where('name', 'currency')->first();
                if(!$currency) {
                    $currency = Attribute::create(['name' => 'currency', 'label' => 'Valuta', 'type' => 'varchar']);
                }
                $event->addAttribute($currency);


                // Default values.
                $data = [
                    'name' => 'Event - Isplata prve rate',
                    'sender' => 'NTP Beograd',
                    'amount' => 25000,
                    'currency' => 'EUR'
                ];

                // Take the input values, if any.
                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                $event->setData($data);
                $this->addEvent($event);
                break;
            default:
                break;
        }

        return $event;

    }

    /**
     * Removes event from contract.
     * @param Event $event
     */
    public function removeEvent(Event $event) {
        $event->instance->delete();
        $this->instance->refresh();
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
            $entity_id = Entity::where('name', 'Contract')->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            foreach ($instances as $instance) {
                $contracts[] = new Contract(['instance_id' => $instance->id]);
            }

            return collect($contracts);
        }

        // If it's id.
        if(!is_array($query)) {
            $instance = Instance::find($query);
            return new Contract(['instance_id' => $instance->id]);
        }

        // If it's really array.
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
            $contract = new Contract(['instance_id' => $item->instance_id]);
            $results_array[] = $contract;
        }

        return collect($results_array);
    }

    /**
     * Returns the short preview of the collection.
     * @return \Illuminate\Support\Collection
     */
    public static function all() {
        return Contract::find();
    }

    public static function getAttributeDefinitions() {
        $attributes = [];

        $name = Attribute::where('name', 'name')->first();
        if(!$name) {
            $name = Attribute::create(['name' => 'name', 'label' => 'Naziv', 'type' => 'varchar']);
        }
        $attributes[] = $name;

        $description = Attribute::where('name', 'description')->first();
        if(!$description) {
            $description = Attribute::create(['name' => 'description', 'label' => 'Opis', 'type' => 'text']);
        }
        $attributes[] = $description;

        $first_party = Attribute::where('name', 'first_party')->first();
        if(!$first_party) {
            $first_party = Attribute::create(['name' => 'first_party', 'label' => 'Prva strana', 'type' => 'varchar']);
        }
        $attributes[] = $first_party;

        $second_party = Attribute::where('name', 'second_party')->first();
        if(!$second_party) {
            $second_party = Attribute::create(['name' => 'second_party', 'label' => 'Druga strana', 'type' => 'varchar']);
        }
        $attributes[] = $second_party;

        $amount = Attribute::where('name', 'amount')->first();
        if(!$amount) {
            $amount = Attribute::create(['name' => 'amount', 'label' => 'Iznos', 'type' => 'double']);
        }
        $attributes[] = $amount;

        $currency = Attribute::where('name', 'currency')->first();
        if(!$currency) {
            $currency = Attribute::create(['name' => 'currency', 'label' => 'Valuta', 'type' => 'varchar']);
        }
        $attributes[] = $currency;

        $contract_subject = Attribute::where('name', 'contract_subject')->first();
        if(!$contract_subject) {
            $contract_subject = Attribute::create(['name' => 'contract_subject', 'label' => 'Predmet ugovora', 'type' => 'text']);
        }
        $attributes[] = $contract_subject;

        return $attributes;

    }

    /**
     * Initializes the attributes.
     */
    protected function setAttributes() {

        // Set contract name.
        Value::put($this->instance->id,
            Attribute::where('name','name')->first(),
            isset($this->data['name']) ? $this->data['name'] : 'Some contract');

        // Set the first contract party.
        Value::put($this->instance->id,
            Attribute::where('name','first_party')->first(),
            isset($this->data['first_party']) ? $this->data['first_party'] : 'First party');

        // Set the second contract party.
        Value::put($this->instance->id,
            Attribute::where('name','second_party')->first(),
            isset($this->data['second_party']) ? $this->data['second_party'] : 'Second party');

        Value::put($this->instance->id,
            Attribute::where('name','contract_subject')->first(),
            isset($this->data['contract_subject']) ? $this->data['contract_subject'] : 'Predmet ugovora');

        // Set the amount of contract
        Value::put($this->instance->id,
            Attribute::where('name','amount')->first(),
            isset($this->data['amount']) ? $this->data['amount'] : 0.0);

        // Set the currency of the amount.
        Value::put($this->instance->id,
            Attribute::where('name','currency')->first(),
            isset($this->data['currency']) ? $this->data['currency'] : 'RSD');

    }

    /**
     * Gets template.
     * @return mixed
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Contract')->first();
        if(!$entity) {
            $entity = Entity::create(['name' => 'Contract', 'description' => 'The document that bounds two or more parties.']);
            $attributes = self::getAttributeDefinitions();
            foreach($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }

        }

        return $entity;
    }


}
