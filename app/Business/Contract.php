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
    public function getSituations() {
        $situations = [];
        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Situation' && $instance->instance->entity->name === 'Contract') {
                $situations[] = new Situation(['instance_id' => $instance->id]);
            }
        }

        return collect($situations);
    }

    /**
     * Return events in the form of an array.
     * @return mixed
     */
    public function getSituationData() {
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
    public function addSituation(Situation $situation) {
        $this->instance->instances()->save($situation->instance);
        $this->instance->refresh();
    }

    public function addSituationByData($situationType, $params = null) {

        $data = [];
        switch($situationType) {
            case 'potpis_ugovora':
                $situation = new Situation();

                // Amount.
                $amount = Attribute::where('name', 'amount')->first();
                if(!$amount) {
                    $amount = Attribute::create(['name' => 'amount', 'label' => 'Iznos', 'type' => 'double']);
                }
                $situation->addAttribute($amount);

                // Currency.
                $currency = Attribute::where('name', 'currency')->first();
                if(!$currency) {
                    $currency = Attribute::create(['name' => 'currency', 'label' => 'Valuta', 'type' => 'varchar']);
                }
                $situation->addAttribute($currency);

                // Contract document.
                $document = Attribute::where('name', 'contract_document')->first();
                if(!$document) {
                    $document = Attribute::create(['name' => 'contract_document', 'label' => 'Priloženi ugovor', 'type' => 'file']);
                }
                $situation->addAttribute($document);

                // Default values.
                $data['name'] = 'Potpis ugovora';
                $data['description'] = 'Potpisan ugovor sa NTP';
                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                $situation->setData($data);
                $this->addSituation($situation);

                break;
            case 'prva_rata':
                $situation = new Situation();
                $amount = Attribute::where('name', 'amount')->first();
                if(!$amount) {
                    $amount = Attribute::create(['name' => 'amount', 'label' => 'Iznos', 'type' => 'double']);
                }
                $situation->addAttribute($amount);

                $currency = Attribute::where('name', 'currency')->first();
                if(!$currency) {
                    $currency = Attribute::create(['name' => 'currency', 'label' => 'Valuta', 'type' => 'varchar']);
                }
                $situation->addAttribute($currency);

                // Default values.
                $data = [
                    'name' => 'Situation - Isplata prve rate',
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

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            default:
                break;
        }

        return $situation;

    }

    /**
     * Removes event from contract.
     * @param Situation $situation
     */
    public function removeSituation(Situation $situation) {
        $situation->instance->delete();
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
            if(Entity::where('name', 'Contract')->get()->count() == 0) {
                return collect([]);
            }

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

    public static function getAttributesDefinition() {
        $attributes = [];

        $attributes[] = self::selectOrCreateAttribute(['name', 'Naziv', 'varchar']);
        $attributes[] = self::selectOrCreateAttribute(['description', 'Opis', 'varchar']);
        $attributes[] = self::selectOrCreateAttribute(['contractor1', 'Prvi potpisnik', 'varchar']);
        $attributes[] = self::selectOrCreateAttribute(['contractor2', 'Drugi potpisnik', 'varchar']);
        $attributes[] = self::selectOrCreateAttribute(['amount', 'Iznos', 'varchar']);
        $attributes[] = self::selectOrCreateAttribute(['currency', 'Valuta', 'varchar']);
        $attributes[] = self::selectOrCreateAttribute(['contract_subject', 'Predmet ugovora', 'text']);
        $attributes[] = self::selectOrCreateAttribute(['signet_at', 'Potpisan dana', 'datetime']);
        $attributes[] = self::selectOrCreateAttribute(['valid_through', 'Važi do', 'datetime']);
        $attributes[] = self::selectOrCreateAttribute(['contract_document', 'Dokument ugovora', 'file']);

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

        $this->getAttribute('contractor1')->setValue(
            isset($this->data['contractor1']) ? $this->data['contractor1'] : 'Prvi ugovarač'
        );

        $this->getAttribute('contractor2')->setValue(
            isset($this->data['contractor2']) ? $this->data['contractor2'] : 'Drugi ugovarač'
        );

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

        $this->instance->attributes->where('name', 'contract_document')->first()->setValue(
            isset($this->data['contract_document']) ? $this->data['contract_document'] : ''
        );

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
            $attributes = self::getAttributesDefinition();
            foreach($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }

        }

        return $entity;
    }


}
