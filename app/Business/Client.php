<?php


namespace App\Business;


use App\Attribute;
use App\AttributeGroup;
use App\Entity;
use App\Instance;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\SingleCommandApplication;

class Client extends BusinessModel
{
    // Public methods. //

    /**
     * Gets the collection of belonging events.
     * @return mixed
     */
    public function getSituations() {
        $situations = [];
        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Situation' && $instance->instance->entity->name === 'Client') {
                $situations[] = new Situation(['instance_id' => $instance->id]);
            }
        }

        return collect($situations);
    }

    /**
     * Gets the collection of belonging contracts.
     * @return \Illuminate\Support\Collection
     */
    public function getContracts() {
        $contracts = [];
        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Contract' && $instance->instance->entity->name === 'Client') {
                $contracts[] = new Contract(['instance_id' => $instance->id]);
            }
        }

        return collect($contracts);
    }

    /**
     * Get situation with given key.
     * @param $key
     * @return mixed
     */
    public function getSituation($key) {
        return Situation::find(['name' => $key])->filter(function($item, $key) {
            if($item->instance->parent_id == $this->getId())
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
    public function addSituation(Situation $situation) {
        $this->instance->instances()->save($situation->instance);
        $this->instance->refresh();
        return $situation;
    }


    public function addContract(Contract $contract) {
        $this->instance->instances()->save($contract->instance);
        $this->instance->refresh();
        return $contract;
    }

    public function addSituationByData($situationType, $params) {
        $data = [];
        switch($situationType) {
            case 'interesovanje':
                $situation = new Situation();
                $application_form = Attribute::where('name', 'application_form')->first();
                if(!$application_form) {
                    $application_form = Attribute::create(['name' => 'application_form', 'label' => 'Obrazac za prijavu', 'type' => 'file', 'sort_order' => 100]);
                }
                $situation->addAttribute($application_form);


                $data = [
                    'name' => $situationType,
                    'description' => 'Interesovanje',
                    'sender' => $this->getData(['name']),
                ];

                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'registracija':
                $situation = new Situation();
                $data = [
                    'name' => $situationType,
                    'description' => 'Registracija',
                    'sender' => 'NTP'
                ];

                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                if(isset($data['application_form'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['application_form', 'Obrazac za prijavu','file', NULL, 100])
                    ],[
                        $data['application_form']
                    ]);
                }

                if(isset($data['client'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['client', 'Klijent', 'varchar', NULL, 5])
                    ],[
                        $data['client']
                    ]);
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'predselekcija':
                $situation = new Situation();

                $data['name'] = $situationType;
                $data['description'] = "Predselekcija";
                $data['sender'] = 'NTP';

                $situation->setData($data);

                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                // Datum evaluacije.
                if(isset($data['eval_date'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['eval_date', 'Datum evaluacije', 'datetime', NULL, 5])
                    ],[
                        $data['eval_date']
                    ]);
                }

                // Prosecna ocena.
                if(isset($data['mark'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['mark', 'Prosečna ocena', 'double', NULL, 6])
                    ],[
                        $data['mark']
                    ]);
                }

                $data['decision'] = $data['decision'] === 'yes';

                // Odluka
                if(isset($data['decision'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['decision', 'Da li je prošao', 'bool', NULL, 7])
                    ],[
                        $data['decision']
                    ]);
                }

                // Primedba.
                if(isset($data['remark'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['remark', 'Primedba komisije', 'text', NULL, 8])
                    ],[
                        $data['remark']
                    ]);
                }

                // Fajl koji je koriscen za procenu.
                if(isset($data['assertion_file'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['assertion_file', 'Fajl za evaluaciju','file', NULL, 9])
                    ],[
                        $data['assertion_file']
                    ]);
                }


                $this->addSituation($situation);
                break;
            case 'sastanak_poziv':
                $situation = new Situation();

                $data['name'] = $situationType;
                $data['description'] = "Poziv na sastanak";
                $data['sender'] = 'NTP';

                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }

                // Datum sastanka.
                if(isset($data['meeting_date'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_date', 'Datum sastanka','datetime', NULL, 4])
                    ],[
                        $data['meeting_date']
                    ]);
                }

                // Mesto sastanka.
                if(isset($data['meeting_place'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_place', 'Mesto sastanka','varchar', NULL, 5])
                    ],[
                        $data['meeting_place']
                    ]);
                }

                // Prisutni na sastanku
                if(isset($data['meeting_participants'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_participants', 'Prisutni na sastanku','text', NULL, 6])
                    ],[
                        $data['meeting_participants']
                    ]);
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'sastanak_potvrda':
                $situation = new Situation();

                $data['name'] = $situationType;
                $data['description'] = "Potvrda datuma sastanka";
                $data['sender'] = "NTP";

                foreach($params as $key => $value) {
                    $data[$key] = $value;
                }


                // Datum sastanka.
                if(isset($data['meeting_date'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_date', 'Datum sastanka','datetime', NULL, 4])
                    ],[
                        $data['meeting_date']
                    ]);
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'odluka':
                $situation = new Situation();

                $data['name'] = $situationType;
                $data['description'] = 'Konačna odluka';
                $data['sender'] = 'NTP';

                foreach($params as $key => $value) {
                    $data[$key] = $value;
                }

                // Beleske sa sastanka.
                if(isset($data['meeting_notes'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_notes', 'Beleške sa sastanka','text', NULL, 4])
                    ],[
                        $data['meeting_notes']
                    ]);
                }

                // Ocena
                if(isset($data['mark'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['mark', 'Ocena', 'double', NULL, 6])
                    ],[
                        $data['mark']
                    ]);
                }

                // Odluka
                if(isset($data['decision'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['decision', 'Odluka','bool', NULL, 7])
                    ],[
                        $data['decision']
                    ]);
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'dodela_prostora':
                $situation = new Situation();

                $data['name'] = $situationType;
                $data['description'] = 'Klijentu se dodeljuju zahtevani servisi i infrastruktura';
                $data['sender'] = 'NTP';

                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }


                if(isset($data['kvadratura'])) {
                    $attribute = self::selectOrCreateAttribute([
                        'kvadratura',
                        'Kancelarijski poslovni prostor - navedite &#13217',
                        'double',
                        NULL,
                        4
                    ]);

                    // In the case that attribute exists, it has oder sort_order
                    // and will not take the value from the argument. We have to
                    // adjust it for the current use.
                    $attribute->sort_order = 4;
                    $attribute->save();
                    $situation->addExtraAttributes([$attribute], [$data['kvadratura']]);
                }

                if(isset($data['zajednicke_prostorije'])) {
                    $attribute = self::selectOrCreateAttribute([
                        'zajednicke_prostorije',
                        'Korišćenje zajedničkih prostorija',
                        'bool',
                        NULL,
                        5
                    ]);

                    // In the case that attribute exists, it has oder sort_order
                    // and will not take the value from the argument. We have to
                    // adjust it for the current use.
                    $attribute->sort_order = 5;
                    $attribute->save();
                    $situation->addExtraAttributes([$attribute], [$data['zajednicke_prostorije']]);
                }

                if(isset($data['inovaciona_laboratorija']))
                {
                    $attribute = self::selectOrCreateAttribute([
                        'inovaciona_laboratorija',
                        'Korišćenje inovacione laboratorije',
                        'bool',
                        NULL,
                        6
                    ]);

                    // In the case that attribute exists, it has oder sort_order
                    // and will not take the value from the argument. We have to
                    // adjust it for the current use.
                    $attribute->sort_order = 6;
                    $attribute->save();
                    $situation->addExtraAttributes([$attribute], [$data['inovaciona_laboratorija']]);
                }

                if(isset($data['konsalting_usluge'])) {
                    $attribute = self::selectOrCreateAttribute([
                        'konsalting_usluge',
                        'Konsalting usluge',
                        'bool',
                        NULL,
                        7
                    ]);

                    // In the case that attribute exists, it has oder sort_order
                    // and will not take the value from the argument. We have to
                    // adjust it for the current use.
                    $attribute->sort_order = 7;
                    $attribute->save();
                    $situation->addExtraAttributes([$attribute], [$data['konsalting_usluge']]);
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'ugovor_poziv':
                $situation = new Situation();

                $data['name'] = $situationType;
                $data['description'] = "Poziv na potpis ugovora";
                $data['sender'] = 'NTP';

                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }

                // Datum sastanka.
                if(isset($data['meeting_date'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_date', 'Datum sastanka','datetime', NULL, 4])
                    ],[
                        $data['meeting_date']
                    ]);
                }

                // Mesto sastanka.
                if(isset($data['meeting_place'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_place', 'Mesto sastanka','varchar', NULL, 5])
                    ],[
                        $data['meeting_place']
                    ]);
                }

                // Prisutni na sastanku
                if(isset($data['meeting_participants'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_participants', 'Prisutni na sastanku','text', NULL, 6])
                    ],[
                        $data['meeting_participants']
                    ]);
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'ugovor_potvrda':
                $situation = new Situation();

                $data['name'] = $situationType;
                $data['description'] = "Potvrda datuma potpisa ugovora";
                $data['sender'] = "NTP";

                foreach($params as $key => $value) {
                    $data[$key] = $value;
                }

                // Datum sastanka.
                if(isset($data['meeting_date'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_date', 'Datum sastanka','datetime', NULL, 4])
                    ],[
                        $data['meeting_date']
                    ]);
                }

                $situation->setData($data);
                $this->addSituation($situation);
                break;
            case 'ugovor_potpis':
                $situation = new Situation();
                $data['name'] = $situationType;
                $data['description'] = 'Potpisivanje ugovora';
                $data['sender'] = 'NTP';
                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }

                if(isset($data['signed_at'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['signed_at', 'Potpisan dana', 'datetime', NULL, 6])
                    ],
                    [
                        $data['signed_at']
                    ]);
                }

                if(isset($data['valid_through'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['valid_through', 'Važi do', 'datetime', NULL, 7])
                    ],[
                        $data['valid_through']
                    ]);
                }

                if(isset($data['contract_document'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['contract_document', 'Dokument ugovora', 'file', NULL, 8])
                    ],[
                        $data['contract_document']
                    ]);
                }

                $situation->setData($data);
                $this->addSituation($situation);

                break;
            case 'odbijanje':
                $situation = new Situation();
                $razlog_odbijanja = Attribute::where('name', 'razlog_odbijanja')->first();
                if(!$razlog_odbijanja) {
                    $razlog_odbijanja = Attribute::create([
                        'name' => 'razlog_odbijanja',
                        'label' => 'Razlog odbijanja',
                        'type' => 'text',
                        'sort_order' => 5
                    ]);
                }
                $situation->addAttribute($razlog_odbijanja);

                $datum_sednice = Attribute::where('name', 'datum_sednice')->first();
                if(!$datum_sednice) {
                    $datum_sednice = Attribute::create([
                        'name' => 'datum_sednice',
                        'label' => 'Datum zasedanja komisije',
                        'type' => 'datetime',
                        'sort_order' => 4
                    ]);
                }
                $situation->addAttribute($datum_sednice);
                $data = [
                    'name' => $situationType,
                    'description' => 'Klijent je odbijen',
                    'sender' => 'NTP',
                    'datum_sednice' => isset($params['datum_sednice']) ? $params['datum_sednice'] : now(),
                    'razlog_odbijanja' =>  isset($params['razlog_odbijanja']) ? $params['razlog_odbijanja'] : 'Nije dat.',
                ];

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
            $clients = [];
            if(Entity::where('name','Client')->get()->count() == 0)
                return collect($clients);
            $entity_id = Entity::where('name', 'Client')->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            foreach ($instances as $instance) {
                $clients[] = new Client(['instance_id' => $instance->id]);
            }

            return collect($clients);
        }

        // If it's id.
        if(!is_array($query)) {
            $instance = Instance::find($query);
            if($instance == null)
                return null;

            return new Client(['instance_id' => $instance->id]);
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
            $client = new Client(['instance_id' => $item->instance_id]);
            $results_array[] = $client;
        }

        return collect($results_array);
    }

    /**
     * Returns the short preview of the collection.
     * @return \Illuminate\Support\Collection
     */
    public static function all() {
        return Client::find();
    }

    /**
     * Returns the set of attributes, neccessary for the creation.
     * @return array
     */
    public static function getCreateAttributesDefinitions() {
        $attributes = [];

        // Name.
        $attributes[] = self::selectOrCreateAttribute(['name', 'Naziv', 'varchar', NULL, 1]);

        // Contact person.
        $attributes[] = self::selectOrCreateAttribute(['contact_person', 'Osoba za kontakt', 'varchar', NULL, 2]);

        // E-mail
        $attributes[] = self::selectOrCreateAttribute(['email', 'E-mail', 'varchar', ['ui' => 'email'], 3]);

        // Password
        $attributes[] = self::selectOrCreateAttribute(['password', 'Lozinka', 'varchar', ['ui' => 'password'], 4]);

        // Telephone.
        $attributes[] = self::selectOrCreateAttribute(['telephone', 'Telefon', 'varchar', NULL, 5]);

        // University.
        $attributes[] = self::selectOrCreateAttribute(['university', 'Fakultet', 'varchar', NULL, 6]);

        // Short inovation desc.
        $attributes[] = self::selectOrCreateAttribute(['ino_desc', 'Kratak opis inovacije', 'text', NULL, 7]);

        // Fields of interest
        $fields_of_interest = self::selectOrCreateAttribute(['interests', 'Oblast poslovanja', 'select', NULL, 8]);
        if(count($fields_of_interest->getOptions()) == 0) {
            $fields_of_interest->addOption(['value' => 1, 'text' => 'IoT и паметни градови']);
            $fields_of_interest->addOption(['value' => 2, 'text' => 'Енергетска ефикасност, зелене, чисте технологије и екологија']);
            $fields_of_interest->addOption(['value' => 3, 'text' => 'Вештачка интелигенција, базе података и аналитика']);
            $fields_of_interest->addOption(['value' => 4, 'text' => 'Прехрана, суплементи и фармацеутски производи']);
            $fields_of_interest->addOption(['value' => 5, 'text' => 'Нови материјали и 3Д штампа']);
            $fields_of_interest->addOption(['value' => 6, 'text' => 'Технологија у спорту']);
            $fields_of_interest->addOption(['value' => 7, 'text' => 'Економске трансакције, финансије, маркетинг и продаја']);
            $fields_of_interest->addOption(['value' => 8, 'text' => 'Роботика и аутоматизација']);
            $fields_of_interest->addOption(['value' => 9, 'text' => 'Туризам и путовања']);
            $fields_of_interest->addOption(['value' => 10, 'text' => 'Едукација, образовање и усавршавање']);
            $fields_of_interest->addOption(['value' => 11, 'text' => 'Медији, комуникације и друштвене мреже/  Гејминг  и забава']);
            $fields_of_interest->addOption(['value' => 12, 'text' => 'Медицинске технологије']);
            $fields_of_interest->addOption(['value' => 13, 'text' => 'Остало']);
        }
        $attributes[] = $fields_of_interest;

        $attributes[] = self::selectOrCreateAttribute(["ostalo_opis", 'Ako ste izabrali "Ostalo" napišite koja je to oblast poslovanja','varchar', NULL, 9]);

        // Why contact us?
        $reason_contact = self::selectOrCreateAttribute(['reason_contact', 'Zašto nas kontaktirate?', 'select', NULL, 10]);
        if(count($reason_contact->getOptions()) == 0) {
            $reason_contact->addOption(['value' => 1, 'text' => 'Opcija 1']);
            $reason_contact->addOption(['value' => 2, 'text' => 'Opcija 2']);
            $reason_contact->addOption(['value' => 3, 'text' => 'Opcija 3']);
        }
        $attributes[] = $reason_contact;

        // Notes (mi unosimo)
        $attributes[] = self::selectOrCreateAttribute(['notes', 'Naša napomena', 'text', NULL, 11]);

        return $attributes;
    }

    /**
     * Get support attributes definitions.
     * @return array
     */
    private static function getSupportAttributes() {
        $attributes = [];

        // Set SUPPORT attributes.

        $podrska = AttributeGroup::get('support');
        if($podrska == null) {
            $podrska = AttributeGroup::create(['name' => 'support', 'label' => 'Potrebna podrška i dodatne napomene', 'sort_order' => 2]);
        }

        $attributes[] = $podrska->addAttribute(self::selectOrCreateAttribute([
            'kvadratura',
            'Kancelarijski poslovni prostor - navedite &#13217',
            'double',
            NULL,
            1
        ]));

        $attributes[] = $podrska->addAttribute(self::selectOrCreateAttribute([
            'zajednicke_prostorije',
            'Korišćenje zajedničkih prostorija',
            'bool',
            NULL,
            2
        ]));

        $attributes[] = $podrska->addAttribute(self::selectOrCreateAttribute([
            'inovaciona_laboratorija',
            'Korišćenje inovacione laboratorije',
            'bool',
            NULL,
            3
        ]));

        $attributes[] = $podrska->addAttribute(self::selectOrCreateAttribute([
            'konsalting_usluge',
            'Konsalting usluge',
            'bool',
            NULL,
            4
        ]));

        return $attributes;
    }

    /**
     * Returns the collection of attributes typical for this type of instance.
     * @return array Attributes array.
     */
    public static function getAttributesDefinition($filter=null) {
        $attributes = [];

        // Set GENERAL attributes.
        $attributes = self::getGeneralAttributes();
        if($filter != null) {
            return $attributes;
        }

        // Faza razvoja

        // Set SUPPORT attributes.
        $attributes = array_merge($attributes, self::getSupportAttributes());

        return $attributes;
    }

    public function getAttributeGroups() {

        $groups[] = AttributeGroup::get('general');
        $groups[] = AttributeGroup::get('support');

        return collect($groups);
    }

    /**
     * Attaches user to the client.
     * @param $user
     */
    public function attachUser($user) {
        $this->instance->attachUser($user);
    }

    public function getAttributesForGroup($group) {
        $groupAttributes = $group->attributes()->get();
        $clientAttributes = [];
        foreach($groupAttributes as $groupAttribute) {
            $clientAttribute = $this->getAttribute($groupAttribute->name);
            if($clientAttribute != NULL)
                $clientAttributes[] = $clientAttribute;
        }

        return collect($clientAttributes);
    }

    // Protected methods. //
    /**
     * Gets or creates template.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Client')->first();
        if(!$entity) {
            $entity = Entity::create(['name' => 'Client', 'description' => 'The company interested in cooperation.']);

            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }

        }

        return $entity;
    }

    /**
     * Sets the attributes.
     */
    protected function setAttributes()
    {
        $this->instance->attributes->where('name', 'name')->first()->setValue(
            isset($this->data['name']) ? $this->data['name'] : ''
        );

        if(isset($this->data['is_registered'])) {
            if($this->data['is_registered'] === 'on')
                $this->data['is_registered'] = true;
            $this->instance->attributes->where('name', 'is_registered')->first()->setValue($this->data['is_registered']);
        }

        $this->instance->attributes->where('name', 'contact_person')->first()->setValue(
            isset($this->data['contact_person']) ? $this->data['contact_person'] : ''
        );

        $this->instance->attributes->where('name', 'email')->first()->setValue(
            isset($this->data['email']) ? $this->data['email'] : ''
        );

        $this->instance->attributes->where('name', 'telephone')->first()->setValue(
            isset($this->data['telephone']) ? $this->data['telephone'] : ''
        );

        $this->instance->attributes->where('name', 'university')->first()->setValue(
            isset($this->data['university']) ? $this->data['university'] : ''
        );

        $this->instance->attributes->where('name', 'date_interested')->first()->setValue(
            isset($this->data['date_interested']) ? $this->data['date_interested'] : NULL
        );

        $this->instance->attributes->where('name', 'date_registered')->first()->setValue(
            isset($this->data['date_registered']) ? $this->data['date_registered'] : NULL
        );

        $this->instance->attributes->where('name', 'interests')->first()->setValue(
            isset($this->data['interests']) ? $this->data['interests'] : []
        );

        $this->instance->attributes->where('name', 'ino_desc')->first()->setValue(
            isset($this->data['ino_desc']) ? $this->data['ino_desc'] : ''
        );

        $this->instance->attributes->where('name', 'reason_contact')->first()->setValue(
            isset($this->data['reason_contact']) ? $this->data['reason_contact'] : ''
        );

        $this->instance->attributes->where('name', 'remark')->first()->setValue(
            isset($this->data['remark']) ? $this->data['remark'] : ''
        );

        $this->instance->attributes->where('name', 'notes')->first()->setValue(
            isset($this->data['notes']) ? $this->data['notes'] : ''
        );

        $this->instance->attributes->where('name', 'status')->first()->setValue(
            isset($this->data['status']) ? $this->data['status'] : 1
        );

        $this->instance->attributes->where('name', 'program')->first()->setValue(
            isset($this->data['program']) ? $this->data['program'] : 1
        );

        $this->instance->attributes->where('name', 'membership')->first()->setValue(
            isset($this->data['membership']) ? $this->data['membership'] : 1
        );

//        $this->instance->attributes->where('name', 'application_form')->first()->setValue(
//            isset($this->data['application_form']) ? $this->data['application_form'] : [
//                'filename' => '',
//                'filelink' => '',
//            ]
//        );

    }

    /**
     * Returns the fields required for the client creation.
     * @return \Illuminate\Support\Collection|void
     */
    protected function getInitAttributesNamesCollection()
    {
        return collect([
            'name',
            'contact_person',
            'email',
            'password',
            'telephone',
            'university',
            'ino_desc',
            'interests',
            'reason_contact',
            'remark'
        ]);
    }

    // Private methods //

    /**
     * Gets the general attributes definitions.
     * @return array
     */
    private static function getGeneralAttributes() {
        $attributes = [];

        $grupaOpstiPodaci = AttributeGroup::get('general');
        if($grupaOpstiPodaci == null) {
            $grupaOpstiPodaci = AttributeGroup::create(['name' => 'general', 'label' => 'Opšti podaci', 'sort_order' => 1]);
        }

        // Name.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['name', 'Naziv', 'varchar', NULL, 1]));

        // Short inovation desc.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['ino_desc', 'Kratak opis inovacije', 'text', NULL, 2]));

        // Fields of interest
        $fields_of_interest = self::selectOrCreateAttribute(['interests', 'Oblast poslovanja', 'select', NULL, 3]);
        if(count($fields_of_interest->getOptions()) == 0) {
            $fields_of_interest->addOption(['value' => 1, 'text' => 'IoT и паметни градови']);
            $fields_of_interest->addOption(['value' => 2, 'text' => 'Енергетска ефикасност, зелене, чисте технологије и екологија']);
            $fields_of_interest->addOption(['value' => 3, 'text' => 'Вештачка интелигенција, базе података и аналитика']);
            $fields_of_interest->addOption(['value' => 4, 'text' => 'Прехрана, суплементи и фармацеутски производи']);
            $fields_of_interest->addOption(['value' => 5, 'text' => 'Нови материјали и 3Д штампа']);
            $fields_of_interest->addOption(['value' => 6, 'text' => 'Технологија у спорту']);
            $fields_of_interest->addOption(['value' => 7, 'text' => 'Економске трансакције, финансије, маркетинг и продаја']);
            $fields_of_interest->addOption(['value' => 8, 'text' => 'Роботика и аутоматизација']);
            $fields_of_interest->addOption(['value' => 9, 'text' => 'Туризам и путовања']);
            $fields_of_interest->addOption(['value' => 10, 'text' => 'Едукација, образовање и усавршавање']);
            $fields_of_interest->addOption(['value' => 11, 'text' => 'Медији, комуникације и друштвене мреже/  Гејминг  и забава']);
            $fields_of_interest->addOption(['value' => 12, 'text' => 'Медицинске технологије']);
            $fields_of_interest->addOption(['value' => 13, 'text' => 'Остало']);
        }
        $attributes[] = $grupaOpstiPodaci->addAttribute($fields_of_interest);

        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(["ostalo_opis", 'Ako ste izabrali "Ostalo" napišite koja je to oblast poslovanja','varchar', NULL, 4]));

        // Contact person.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['contact_person', 'Osoba za kontakt', 'varchar', NULL, 5]));

        // E-mail
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['email', 'E-mail', 'varchar', ['ui' => 'email'], 6]));

        // Password
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['password', 'Lozinka', 'varchar', ['ui' => 'password'], 7]));

        // Telephone.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['telephone', 'Telefon', 'varchar', NULL, 8]));

        // University.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['university', 'Fakultet', 'varchar', NULL, 9]));

        // Date interested.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['date_interested', 'Datum interesovanja', 'datetime', NULL, 10]));


        // O S N I V A C I
        // I Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_1_imeprezime', 'Osnivac 1 - Ime i prezime', 'varchar', ['ui' => 'hide'], 11]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_1_fakultet', 'Osnivac 1 - Fakultet', 'varchar', ['ui' => 'hide'], 12]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_1_udeo', 'Osnivac 1 - Udeo u društvu', 'varchar', ['ui' => 'hide'], 13]));

        // II Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_2_imeprezime', 'Osnivac 2 - Ime i prezime', 'varchar', ['ui' => 'hide'], 14]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_2_fakultet', 'Osnivac 2 - Fakultet','varchar', ['ui' => 'hide'], 15]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_2_udeo', 'Osnivac 2 - Udeo u društvu', 'varchar', ['ui' => 'hide'], 16]));

        // III Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_3_imeprezime', 'Osnivac 3 - Ime i prezime', 'varchar', ['ui' => 'hide'], 17]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_3_fakultet', 'Osnivac 3 - Fakultet', 'varchar', ['ui' => 'hide'], 18]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_3_udeo', 'Osnivac 3 - Udeo u društvu', 'varchar', ['ui' => 'hide'], 19]));

        // IV Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_4_imeprezime', 'Osnivac 4 - Ime i prezime', 'varchar', ['ui' => 'hide'], 20]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_4_fakultet', 'Osnivac 4 - Fakultet', 'varchar', ['ui' => 'hide'], 21]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_4_udeo', 'Osnivac 4 - Udeo u društvu', 'varchar', ['ui' => 'hide'], 22]));

        // V Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_5_imeprezime', 'Osnivac 5 - Ime i prezime', 'varchar', ['ui' => 'hide'], 23]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_5_fakultet', 'Osnivac 5 - Fakultet', 'varchar', ['ui' => 'hide'], 24]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_5_udeo', 'Osnivac 5 - Udeo u društvu', 'varchar', ['ui' => 'hide'], 25]));

        // VI Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_6_imeprezime', 'Osnivac 6 - Ime i prezime', 'varchar', ['ui' => 'hide'], 26]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_6_fakultet', 'Osnivac 6 - Fakultet', 'varchar', ['ui' => 'hide'], 27]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_6_udeo', 'Osnivac 6 - Udeo u društvu', 'varchar', ['ui' => 'hide'], 28]));


        // Why contact us?
        $reason_contact = self::selectOrCreateAttribute(['reason_contact', 'Zašto nas kontaktirate?', 'select', NULL, 29]);
        if(count($reason_contact->getOptions()) == 0) {
            $reason_contact->addOption(['value' => 1, 'text' => 'Opcija 1']);
            $reason_contact->addOption(['value' => 2, 'text' => 'Opcija 2']);
            $reason_contact->addOption(['value' => 3, 'text' => 'Opcija 3']);
        }
        $attributes[] = $grupaOpstiPodaci->addAttribute($reason_contact);

        // Notes (mi unosimo)
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['notes', 'Naša napomena', 'text', NULL, 30]));

        if(isset($filter) && $filter === 'start')
            return $attributes;

        // Is is registered?
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['is_registered', 'Da li je registrovan(a)', 'bool', NULL, 31]));

        // Ako je registrovano, kada?
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['date_registered', 'Datum registracije, ako je društvo registrovano', 'datetime', NULL, 32]));


        // Napomena (oni unose)
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['remark', 'Napomena kandidata', 'text', NULL, 33]));

        // Status člana.
        $status = self::selectOrCreateAttribute(['status', 'Status člana', 'select', NULL, 34]);
        if(count($status->getOptions()) == 0) {
            $status->addOption(['value' => 1, 'text' => 'Zainteresovan']);
            $status->addOption(['value' => 2, 'text' => 'Prijavljen']);
            $status->addOption(['value' => 3, 'text' => 'Pre-selektovan']);
            $status->addOption(['value' => 4, 'text' => 'Pozvan na sastanak']);
            $status->addOption(['value' => 5, 'text' => 'Datum sastanka potvrđen']);
            $status->addOption(['value' => 6, 'text' => 'Prihvaćena prijava']);
            $status->addOption(['value' => 7, 'text' => 'Odbijena prijava']);
            $status->addOption(['value' => 8, 'text' => 'Dodeljen prostor']);
            $status->addOption(['value' => 9, 'text' => 'Pozvan na potpis ugovora']);
            $status->addOption(['value' => 10, 'text' => 'Potvrdjen datum potpisa ugovora']);
            $status->addOption(['value' => 11, 'text' => 'Potpisan ugovor']);
        }
        $attributes[] = $grupaOpstiPodaci->addAttribute($status);



        // Vrsta članstva
        $membership = self::selectOrCreateAttribute(['membership', 'Članstvo', 'select', NULL, 36]);
        if(count($membership->getOptions()) == 0) {
            $membership->addOption(['value' => 1, 'text' => 'Virtuelni član']);
            $membership->addOption(['value' => 2, 'text' => 'Punopravni član']);
            $membership->addOption(['value' => 3, 'text' => 'Alumni']);

        }
        $attributes[] = $grupaOpstiPodaci->addAttribute($membership);

        // Prijava za članstvo - dokument.
//        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['application_form', 'Obrazac za prijavu', 'file', NULL, 37]));

        // Matični broj.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['maticni_broj', "Matični broj", 'varchar', NULL, 38]));

        // Broj zaposlenih, od koga broj žena.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['broj_zaposlenih', "Broj zaposlenih", 'varchar', NULL, 39]));

        // Adresa društva.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['address', 'Adresa', 'varchar', NULL, 40]));

        // Sajt.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['website', 'Sajt', 'varchar', NULL, 41]));

        // Da li se planira registracija u sledećih 3 meseca?
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['registration_planned', 'Da li se planira registracija u sledećih 3 meseca?', 'bool', NULL, 43]));

        // Program.
        $program = self::selectOrCreateAttribute(['program', 'Konkurišete za:', 'select', NULL, 44]);
        if(count($program->getOptions()) == 0) {
            $program->addOption(['value' => 1, 'text' => 'ParkUp']);
            $program->addOption(['value' => 2, 'text' => 'Colosseum']);
            $program->addOption(['value' => 3, 'text' => 'ImagineIF']);
            $program->addOption(['value' => 4, 'text' => 'Predinkubacija']);
            $program->addOption(['value' => 5, 'text' => 'Inkubacija NTP']);
            $program->addOption(['value' => 6, 'text' => 'Inkubacija BITF']);
            $program->addOption(['value' => 7, 'text' => 'Rastuće kompanije']);
            $program->addOption(['value' => 8, 'text' => 'Pre-seed']);
        }
        $attributes[] = $grupaOpstiPodaci->addAttribute($program);

        return $attributes;
    }



}
