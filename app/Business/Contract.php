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
            if($instance->entity->name === 'Situation') {
                if( $instance->parentInstances->first()->entity->name === 'Contract')
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
     * Get situation with given key.
     * @param $key
     * @return mixed
     */
    public function getSituation($key) {
        return Situation::find(['name' => $key])->filter(function($item, $key) {
            if($item->instance->parentInstances->first()->id == $this->instance->id)
                return $item;
        })->first();

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
            case __('Contract Signing'):
                $situation = new Situation();
                $data['name'] = $situationType;
                $data['description'] = 'Potpisan je ugovor sa klijentom. Realizacija ugovora će se pratiti periodično putem izveštaja i pregleda aktivnosti klijenta.';
                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }
                $situation->setData($data);

                // Amount.
                if(isset($data['amount'])) {
                    $situation->addExtraAttributes([self::selectOrCreateAttribute(['amount', 'Iznos', 'double', NULL, 1])], [ $data['amount']]);
                }

                // Currency.
                if(isset($data['currency'])) {
                    $situation->addExtraAttributes([self::selectOrCreateAttribute(['currency', 'Valuta', 'varchar', NULL, 2])], [ $data['currency']]);
                }

                // Contract document.
                if(isset($data['contract_document'])) {
                    $situation->addExtraAttributes([self::selectOrCreateAttribute(['contract_document', 'Priloženi ugovor', 'file', NULL, 3])], [ $data['contract_document']]);
                }

                $this->addSituation($situation);

                break;
            case __('Installment I'):
                $situation = new Situation();
                $amount = Attribute::where('name', 'amount')->first();
                if(!$amount) {
                    $amount = Attribute::create(['name' => 'amount', 'label' => 'Iznos', 'type' => 'double', 'sort_order' => 1]);
                }
                $situation->addAttribute($amount);

                $currency = Attribute::where('name', 'currency')->first();
                if(!$currency) {
                    $currency = Attribute::create(['name' => 'currency', 'label' => 'Valuta', 'type' => 'varchar', 'sort_order' => 2]);
                }
                $situation->addAttribute($currency);

                $situation->addAttribute(self::selectOrCreateAttribute(['payed', 'Plaćeno', 'double', null, 3]));
                $situation->addAttribute(self::selectOrCreateAttribute(['on_hold', 'Na čekanju', 'double', null, 4]));
                $situation->addAttribute(self::selectOrCreateAttribute(['remains', 'Preostalo', 'double', null, 5]));

                // Default values.
                $data = [
                    'name' => $situationType,
                    'description' => 'Isplata prve rate ugovora. Iznos rate je dogovoren detaljima ugovora.',
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
            case __('Moving In'):
                $situation = new Situation();
                $situation->addAttribute(self::selectOrCreateAttribute(['area', 'Površina','double', NULL, 1 ]));
                $situation->addAttribute(self::selectOrCreateAttribute(['date_of_moving_in', 'Datum useljenja', 'datetime', NULL, 2]));
                $situation->addAttribute(self::selectOrCreateAttribute(['status', '', NULL, 3]));
                $data = [
                    'name' => $situationType,
                    'description' => 'Evidencija useljenja klijenta u poslovni prostor, koji je specificiran u prijavnoj formi.',
                    'sender' => 'NTP Beograd'
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
     *
     * Returns the object or collection of objects, based
     * on the entered query.
     *
     * @param null $query
     * @return Contract|\Illuminate\Support\Collection|null
     */
    public static function find($query=null)
    {
        if(Entity::where('name', 'Contract')->get()->count() == 0) {
            return isset($query) && is_string($query) ? null : collect([]);
        }

        // If it's empty.
        if(!isset($query)) {
            $entity_id = Entity::where('name', 'Contract')->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            return $instances->map(function($instance) {
                return new Contract(['instance_id' => $instance->id]);
            });

        }

        // If it's id.
        if(!is_array($query)) {
            $entity_id = Entity::whereName('Contract')->first()->id;
            $instance = Instance::where(['id' => $query, 'entity_id' => $entity_id])->first();
            if($instance == null)
                return null;

            return new Contract(['instance_id' => $instance->id]);
        }

        // If it's really array.
        foreach($query as $key => $value) {

            $attribute = Attribute::where('name', $key)->first();
            $tableName = $attribute->type.'_values';
            $temporary_results = DB::table($tableName)->select('instance_id')->where(['value' => $value, 'attribute_id' => $attribute->id])->get();

            if(!isset($results)) {
                $results = $temporary_results;
            } else {
                $results = $temporary_results->intersect($results);
            }

            if($results->count() === 0) {
                return $results;
            }

        }

        if(isset($results)) {
            return $results->map(function($item, $key) {
                return new Contract(['instance_id' => $item->instance_id]);
            });
        }

        return null;

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

        $attributes[] = self::selectOrCreateAttribute(['contract_number', 'Br. Ugovora', 'varchar', NULL, 1]);
        $attributes[] = self::selectOrCreateAttribute(['name', 'Naziv', 'varchar', NULL, 2]);
        $attributes[] = self::selectOrCreateAttribute(['description', 'Opis', 'varchar', NULL, 3]);
        $attributes[] = self::selectOrCreateAttribute(['amount', 'Iznos', 'double', NULL, 4]);
        $attributes[] = self::selectOrCreateAttribute(['currency', 'Valuta', 'varchar', NULL, 5]);
        $attributes[] = self::selectOrCreateAttribute(['contract_subject', 'Predmet ugovora', 'text', NULL, 6]);
        $attributes[] = self::selectOrCreateAttribute(['signed_at', 'Potpisan dana', 'datetime', NULL, 7]);
        $attributes[] = self::selectOrCreateAttribute(['valid_through', 'Važi do', 'datetime', NULL, 8]);
        $attributes[] = self::selectOrCreateAttribute(['contract_document', 'Dokument ugovora', 'file', NULL, 9]);
        $contract_status = self::selectOrCreateAttribute(['contract_status', 'Status ugovora', 'select', NULL, 10]);
        if(count($contract_status->getOptions()) == 0) {
            $contract_status->addOption(['value' => 1, 'text' => 'Potpisan']);
            $contract_status->addOption(['value' => 2, 'text' => 'Isplaćena I rata']);
            $contract_status->addOption(['value' => 3, 'text' => 'Validiran izveštaj 3 meseca']);
            $contract_status->addOption(['value' => 4, 'text' => 'Validiran izveštaj 6 meseci']);
            $contract_status->addOption(['value' => 5, 'text' => 'Validiran konačni izveštaj']);
            $contract_status->addOption(['value' => 6, 'text' => 'Isplaćena II rata']);
            $contract_status->addOption(['value' => 7, 'text' => 'Uspešno završen']);
            $contract_status->addOption(['value' => 8, 'text' => 'Prekinut']);
            $contract_status->addOption(['value' => 9, 'text' => 'Arhiviran']);
        }
        $attributes[] = $contract_status;

        return $attributes;

    }

    public function getAttributeGroups() {

        // Empty, for now.
        return collect([]);
    }


    /**
     * Returns the client that owns the contract.
     * @return Client|Contract|\Illuminate\Support\Collection|null
     */
    public function getClient() {
        if($this->instance->parentInstances->first() != null) {
            $client = Client::find($this->instance->parentInstances->first()->id);
            return $client;
        }

        return null;
    }

    /**
     * Sets the attributes either with data or with the default values.
     * @param null $data
     */
    protected function setAttributes($data = null) {

        // Set contract name.
        Value::put($this->instance->id,
            Attribute::where('name','name')->first(),
            $data['name'] ?? 'Some contract');

        Value::put($this->instance->id,
            Attribute::where('name','contract_subject')->first(),
            $data['contract_subject'] ?? 'Predmet ugovora');

        Value::put($this->instance->id,
            Attribute::where('name','contract_number')->first(),
            $data['contract_number'] ?? '');

        // Set the amount of contract
        Value::put($this->instance->id,
            Attribute::where('name','amount')->first(),
            $data['amount'] ?? 0.0);

        // Set the currency of the amount.
        Value::put($this->instance->id,
            Attribute::where('name','currency')->first(),
            $data['currency'] ?? 'RSD');

        $this->instance->attributes->where('name', 'contract_document')->first()->setValue(
            $data['contract_document'] ?? ''
        );

        if(isset($data['signed_at'])) {
            $this->getAttribute('signed_at')->setValue($data['signed_at']);
        }

        if(isset($data['valid_through'])) {
            $this->getAttribute('valid_through')->setValue($data['valid_through']);
        }

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
