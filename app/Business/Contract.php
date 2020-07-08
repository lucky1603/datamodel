<?php


namespace App\Business;

use App\Attribute;
use App\Entity;
use App\Instance;
use App\Value;
use Illuminate\Support\Facades\DB;

class Contract extends BusinessModel
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    /**
     * Gets the collection of belonging events.
     * @return mixed
     */
    public function getEvents() {
        $events = [];
        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Event') {
                $events[] = new Event(['instance_id' => $instance->id]);
            }
        }

        return collect($events);
    }

    /**
     * Adds event to contract.
     * @param Event $event
     */
    public function addEvent(Event $event) {
        $this->instance->instances()->save($event->instance);
        $this->instance->refresh();
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
            if($key === 'code') {
                $instance = Instance::where('code', $value)->first();
                if($instance->entity->name === 'Contract') {
                    return new Contract(['instance_id' => $instance->id]);
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
        return Contract::find()->map(function($contract) {
            return $contract->instance->id.'-'.$contract->instance->code;
        });
    }

    /**
     * Initializes the attributes.
     */
    protected function setAttributes() {
        if($this->instance->attributes()->where('name', 'first_party')->count() == 0) {
            $first_party = Attribute::where('name', 'first_party')->first();
            if(!$first_party) {
                $first_party = Attribute::create(['name' => 'first_party', 'label' => 'Prva strana', 'type' => 'varchar']);
            }
            $this->instance->addAttribute($first_party);
        }

        if($this->instance->attributes()->where('name', 'second_party')->count() == 0) {
            $second_party = Attribute::where('name', 'second_party')->first();
            if (!$second_party) {
                $second_party = Attribute::create(['name' => 'second_party', 'label' => 'Druga strana', 'type' => 'varchar']);
            }
            $this->instance->addAttribute($second_party);
        }

        if($this->instance->attributes()->where('name', 'amount')->count() == 0) {
            $amount = Attribute::where('name', 'amount')->first();
            if (!$amount) {
                $amount = Attribute::create(['name' => 'amount', 'label' => 'Iznos', 'type' => 'double']);
            }
            $this->instance->addAttribute($amount);
        }

        if($this->instance->attributes()->where('name', 'currency')->count() == 0) {
            $currency = Attribute::where('name', 'currency')->first();
            if (!$currency) {
                $currency = Attribute::create(['name' => 'currency', 'label' => 'Valuta', 'type' => 'varchar']);
            }
            $this->instance->addAttribute($currency);
        }

        if($this->instance->attributes()->where('name', 'contract_subject')->count() == 0) {
            $subject = Attribute::where('name', 'contract_subject')->first();
            if (!$subject) {
                $subject = Attribute::create(['name' => 'contract_subject', 'label' => 'Predmet ugovora', 'type' => 'text']);
            }
            $this->instance->addAttribute($subject);
        }

        // Set contract name.
        Value::put($this->instance->id,
            Attribute::where('name','name')->first(),
            isset($this->data['name']) ? $this->data['name'] : 'Some contract');

        // Set description of contract.
        Value::put($this->instance->id,
            Attribute::where('name','description')->first(),
            isset($this->data['description']) ? $this->data['description'] : 'Some description');

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
            $entity = App\Entity::create(['name' => 'Contract', 'description' => 'The document that bounds two or more parties.']);

            $name = Attribute::where('name', 'name')->first();
            if(!$name) {
                Attribute::create(['name' => 'name', 'label' => 'Naziv', 'type' => 'varchar']);
            }
            $entity->addAttribute($name);

            $description = Attribute::where('name', 'description')->first();
            if(!$description) {
                Attribute::create(['name' => 'description', 'label' => 'Opis', 'type' => 'text']);
            }
            $entity->addAttribute($name);
        }

        return $entity;
    }



}
