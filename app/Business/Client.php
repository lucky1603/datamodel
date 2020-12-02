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
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

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
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

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
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

                $data['name'] = $situationType;
                $data['description'] = "Predselekcija";
                $data['sender'] = 'NTP';

                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                $situation->setData($data);

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
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

                $data['name'] = $situationType;
                $data['description'] = "Poziv na sastanak";
                $data['sender'] = 'NTP';

                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }

                $situation->setData($data);

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

                $this->addSituation($situation);
                break;
            case 'sastanak_potvrda':
                $situation = new Situation();
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

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
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

                $data['name'] = $situationType;
                $data['description'] = 'Konačna odluka';
                $data['sender'] = 'NTP';

                foreach($params as $key => $value) {
                    $data[$key] = $value;
                }

                $situation->setData($data);

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

                $this->addSituation($situation);
                break;
            case 'dodela_prostora':
                $situation = new Situation();
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

                $data['name'] = $situationType;
                $data['description'] = 'Klijentu se dodeljuju zahtevani servisi i infrastruktura';
                $data['sender'] = 'NTP';

                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }

                $situation->setData($data);


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


                $this->addSituation($situation);
                break;
            case 'ugovor_poziv':
                $situation = new Situation();
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

                $data['name'] = $situationType;
                $data['description'] = "Poziv na potpis ugovora";
                $data['sender'] = 'NTP';

                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }

                $situation->setData($data);

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

                $this->addSituation($situation);
                break;
            case 'ugovor_potvrda':
                $situation = new Situation();
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

                $data['name'] = $situationType;
                $data['description'] = "Potvrda datuma potpisa ugovora";
                $data['sender'] = "NTP";

                foreach($params as $key => $value) {
                    $data[$key] = $value;
                }

                $situation->setData($data);

                // Datum sastanka.
                if(isset($data['meeting_date'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_date', 'Datum sastanka','datetime', NULL, 4])
                    ],[
                        $data['meeting_date']
                    ]);
                }

                $this->addSituation($situation);
                break;
            case 'ugovor_potpis':
                $situation = new Situation();
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

                $data['name'] = $situationType;
                $data['description'] = 'Potpisivanje ugovora';
                $data['sender'] = 'NTP';

                foreach ($params as $key => $value) {
                    $data[$key] = $value;
                }

                $situation->setData($data);

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


                $this->addSituation($situation);

                break;
            case 'odbijanje':
                $situation = new Situation();
                $situation->addAttribute(self::selectOrCreateAttribute(['status', null, null,0]));

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

        // FUnkcija - polozaj.
        $attributes[] = self::selectOrCreateAttribute(['position', 'Položaj/Funkcija', 'varchar', NULL, 7]);

        // Fotografija.
        $attributes[] = self::selectOrCreateAttribute(['photo', 'Fotografija', 'file', NULL, 8]);

        // Short inovation desc.
        $attributes[] = self::selectOrCreateAttribute(['ino_desc', 'Kratak opis inovacije', 'text', NULL, 9]);

        // Fields of interest
        $fields_of_interest = self::selectOrCreateAttribute(['interests', 'Oblast poslovanja', 'select', NULL, 10]);
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

        $attributes[] = self::selectOrCreateAttribute(["ostalo_opis", 'Ako ste izabrali "Ostalo" napišite koja je to oblast poslovanja','varchar', NULL, 11]);

        // Why contact us?
        $reason_contact = self::selectOrCreateAttribute(['reason_contact', 'Zašto nas kontaktirate?', 'select', NULL, 12]);
        if(count($reason_contact->getOptions()) == 0) {
            $reason_contact->addOption(['value' => 1, 'text' => 'Opcija 1']);
            $reason_contact->addOption(['value' => 2, 'text' => 'Opcija 2']);
            $reason_contact->addOption(['value' => 3, 'text' => 'Opcija 3']);
        }
        $attributes[] = $reason_contact;

        // Notes (mi unosimo)
        $attributes[] = self::selectOrCreateAttribute(['notes', 'Naša napomena', 'text', NULL, 13]);

        $attributes[] = self::selectOrCreateAttribute(['logo', 'Logo klijenta', 'file', NULL, 14]);
        $attributes[] = self::selectOrCreateAttribute(['profile_background', 'Profilna slika', 'file', NULL, 15]);

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
            $podrska = AttributeGroup::create(['name' => 'support', 'label' => 'Potrebna podrška i dodatne napomene', 'sort_order' => 10]);
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
    public static function getAttributesDefinition() {
        $attributes = [];

        // Set GENERAL attributes.
        $attributes = self::getGeneralAttributes();

        // Problem i ciljna grupa.
        $attributes = array_merge($attributes, self::getTargetGroupAttributes());

        // Inovativnost.
        $attributes = array_merge($attributes, self::getInnovationAttributes());

        // Tim.
        $attributes = array_merge($attributes, self::getTeamAttributes());

        // Finansiranje i nagrade.
        $attributes = array_merge($attributes, self::getFinancingAndPrizesAttributes());

        // Poslovni model.
        $attributes = array_merge($attributes, self::getBusinessModelAttributes());

        // Poslovna preduzetnost.
        $attributes = array_merge($attributes, self::getEnterpreneurReadynessAttributes());

        // Set SUPPORT attributes.
        $attributes = array_merge($attributes, self::getSupportAttributes());

        return $attributes;
    }

    /**
     * Vraća grupe atributa.
     * @return \Illuminate\Support\Collection
     */
    public function getAttributeGroups() {

        $groups[] = AttributeGroup::get('general');
        $groups[] = AttributeGroup::get('target_group');
        $groups[] = AttributeGroup::get('innovation_group');
        $groups[] = AttributeGroup::get('team_group');
        $groups[] = AttributeGroup::get('financing_prizing_group');
        $groups[] = AttributeGroup::get('business_model_group');
        $groups[] = AttributeGroup::get('enterpreneur_readyness');
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

        $this->instance->attributes->where('name', 'logo')->first()->setValue(
            isset($this->data['logo']) ? $this->data['logo'] : [
                'filename' => '',
                'filelink' => '',
            ]
        );

        $this->instance->attributes->where('name', 'profile_background')->first()->setValue(
            isset($this->data['profile_background']) ? $this->data['profile_background'] : [
                'filename' => '',
                'filelink' => '',
            ]
        );

        $this->instance->attributes->where('name', 'photo')->first()->setValue(
            isset($this->data['photo']) ? $this->data['photo'] : [
                'filename' => '',
                'filelink' => '',
            ]
        );

        $this->instance->attributes->where('name', 'position')->first()->setValue(
            isset($this->data['position']) ? $this->data['position'] : ''
        );
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

        // Photo.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['photo', 'Fotografija', 'file', NULL, 10]));

        // Position.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['position', 'Pozicija', 'varchar', NULL, 11]));

        // Date interested.
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['date_interested', 'Datum interesovanja', 'datetime', NULL, 12]));


        // O S N I V A C I
        // I Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_1_imeprezime', 'Osnivac 1 - Ime i prezime', 'varchar', NULL, 13]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_1_fakultet', 'Osnivac 1 - Fakultet', 'varchar', NULL, 14]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_1_udeo', 'Osnivac 1 - Udeo u društvu', 'varchar', NULL, 15]));

        // II Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_2_imeprezime', 'Osnivac 2 - Ime i prezime', 'varchar', NULL, 16]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_2_fakultet', 'Osnivac 2 - Fakultet','varchar', NULL, 17]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_2_udeo', 'Osnivac 2 - Udeo u društvu', 'varchar', NULL, 18]));

        // III Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_3_imeprezime', 'Osnivac 3 - Ime i prezime', 'varchar', NULL, 19]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_3_fakultet', 'Osnivac 3 - Fakultet', 'varchar', NULL, 20]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_3_udeo', 'Osnivac 3 - Udeo u društvu', 'varchar', NULL, 21]));

        // IV Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_4_imeprezime', 'Osnivac 4 - Ime i prezime', 'varchar', NULL, 22]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_4_fakultet', 'Osnivac 4 - Fakultet', 'varchar', NULL, 23]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_4_udeo', 'Osnivac 4 - Udeo u društvu', 'varchar', NULL, 24]));

        // V Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_5_imeprezime', 'Osnivac 5 - Ime i prezime', 'varchar', NULL, 25]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_5_fakultet', 'Osnivac 5 - Fakultet', 'varchar', NULL, 26]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_5_udeo', 'Osnivac 5 - Udeo u društvu', 'varchar', NULL, 27]));

        // VI Osnivac
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_6_imeprezime', 'Osnivac 6 - Ime i prezime', 'varchar', NULL, 28]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_6_fakultet', 'Osnivac 6 - Fakultet', 'varchar', NULL, 29]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['osnivac_6_udeo', 'Osnivac 6 - Udeo u društvu', 'varchar', NULL, 30]));


        // Why contact us?
        $reason_contact = self::selectOrCreateAttribute(['reason_contact', 'Zašto nas kontaktirate?', 'select', NULL, 31]);
        if(count($reason_contact->getOptions()) == 0) {
            $reason_contact->addOption(['value' => 1, 'text' => 'Opcija 1']);
            $reason_contact->addOption(['value' => 2, 'text' => 'Opcija 2']);
            $reason_contact->addOption(['value' => 3, 'text' => 'Opcija 3']);
        }
        $attributes[] = $grupaOpstiPodaci->addAttribute($reason_contact);

        // Notes (mi unosimo)
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['notes', 'Naša napomena', 'text', NULL, 32]));

        // Is is registered?
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['is_registered', 'Da li je registrovan(a)', 'bool', NULL, 33]));

        // Ako je registrovano, kada?
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['date_registered', 'Datum registracije, ako je društvo registrovano', 'datetime', NULL, 34]));


        // Napomena (oni unose)
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['remark', 'Napomena kandidata', 'text', NULL, 35]));

        // Status člana.
        $status = self::selectOrCreateAttribute(['status', 'Status člana', 'select', NULL, 36]);
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
        $membership = self::selectOrCreateAttribute(['membership', 'Članstvo', 'select', NULL, 37]);
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

        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['logo', 'Logo klijenta', 'file', NULL, 45]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['profile_background', 'Profilna slika', 'file', NULL, 46]));

        return $attributes;
    }

    /**
     * Returns the group of attributes connected with the groups - 'Problem i ciljna grupa'
     * @return array
     */
    private static function getTargetGroupAttributes() {
        $attributes = [];

        $grupaOpstiPodaci = AttributeGroup::get('target_group');
        if($grupaOpstiPodaci == null) {
            $grupaOpstiPodaci = AttributeGroup::create(['name' => 'target_group', 'label' => 'Problem i ciljna grupa', 'sort_order' => 2]);
        }

        $fazarazvoja = self::selectOrCreateAttribute(['development_phase', 'Faza razvoja', 'select', NULL, 1]);
        if($fazarazvoja != null && count($fazarazvoja->getOptions()) == 0) {
            $fazarazvoja->addOption(['value' => 1, 'text' => 'Ideja']);
            $fazarazvoja->addOption(['value' => 2, 'text' => 'Proof of Concept']);
            $fazarazvoja->addOption(['value' => 3, 'text' => 'Minimal Viable Product']);
        }
        $attributes[] = $grupaOpstiPodaci->addAttribute($fazarazvoja);

        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['poblems', 'Problemi koji se rešavaju vašim proizvodom/uslugom', 'text', NULL, 2]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['target_group_solution_and_competition', 'Navedite kako ciljna grupa sada rešava problem i bar jednog konkurenta', 'text', NULL, 3]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['target_groups', 'Наведите и опишите своје циљне групе (кориснике и купце) са профилом раног усвајача, уз осврт на активности и комуникацију коју сте имали са циљном групом до сада. Такође, наведите уколико имате купце који плаћају. * ', 'text', NULL,4]));
        $attributes[] = $grupaOpstiPodaci->addAttribute(self::selectOrCreateAttribute(['target_markets', 'Наведите која су ваша циљна тржишта, на којим тржиштима сада послујете (ако имате продају) и на којима намеравате.Наведите која је Ваша стратегија изласка на страна тржишта и које су вам предикције за наредних три, шест и девет месеци  (која тржишта планирате да освојите, колико плаћајућих купаца,
        MRR***, директну продају итд). * ', 'text', NULL, 5]));

        return $attributes;

    }

    /**
     * Vraca grupu inovacionih atributa.
     * @return array
     */
    private static function getInnovationAttributes() {
        $attributes = [];

        $grupaInovativnost = AttributeGroup::get('innovation_group');
        if($grupaInovativnost == null) {
            $grupaInovativnost = AttributeGroup::create(['name' => 'innovation_group', 'label' => 'Inovativnost', 'sort_order' => 3]);
        }

        $attributes[] = $grupaInovativnost->addAttribute(self::selectOrCreateAttribute(['product_description', 'Опишите свој производ/услугу/процес и дефинишите елементе и шта је то што га чини важним алатом за корисникове потребе. Наведите и докле сте стигли са развојем иновације уз таксативан осврт на активности које сте предузели до сада: *', 'text', NULL, 1]));

        $inovationType = self::selectOrCreateAttribute(['inovation_type', 'Tip inovacije', 'select', NULL, 2]);
        if($inovationType != null && count($inovationType->getOptions()) == 0) {
            $inovationType->addOption(['value' => 1,  'text' => 'Већ примењено решење ']);
            $inovationType->addOption(['value' => 2,  'text' => 'Познато али недовољно примењено решење ']);
            $inovationType->addOption(['value' => 3,  'text' => 'Унапређено постојеће решење']);
            $inovationType->addOption(['value' => 4,  'text' => 'Значајно унапређено постојеће решење ']);
            $inovationType->addOption(['value' => 5,  'text' => 'Потпуно ново решење ']);
        }
        $attributes[] = $grupaInovativnost->addAttribute($inovationType);

        $attributes[] = $grupaInovativnost->addAttribute(self::selectOrCreateAttribute(['inovativity', 'Наведите и опишите иновативност Вашег решењa (технолошка иновација, иновација у пословном моделу, процесу, итд) * ', 'text', NULL, 3]));
        $attributes[] = $grupaInovativnost->addAttribute(self::selectOrCreateAttribute(['intelectual_property_protection', 'Наведите да ли сте истраживали могућности заштите интелектуалне својине и, ако јесте, опишите ваше даље планове у овом смеру или сте већ заштитили интелектуалну својину и на који начин (патент, мали патент, индустријски дизајн, жиг и др.): * ', 'text', NULL, 4]));
        $attributes[] = $grupaInovativnost->addAttribute(self::selectOrCreateAttribute(['mvp_testing', 'Наведите искуства са тестирања МVP или прототипа (уколико га имате):', 'text', NULL, 5]));

        return $attributes;
    }


    /**
     * Vraća grupu tim i pripadajuće atribute.
     * @return array
     */
    private static function getTeamAttributes() {
        $attributes = [];

        $grupaTim = AttributeGroup::get('team_group');
        if($grupaTim == null) {
           $grupaTim = AttributeGroup::create(['name' => 'team_group', 'label' => 'Tim', 'sort_order' => 4]);
        }

        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['team_members', 'Članovi tima', 'text', NULL, 1]));
        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['team_members_file', 'Подаци о оснивачима привредног друштва (лични подаци и кратке професионалне биографије за свако лице) или линкови ка LinkedIn профилима: ', 'file', NULL, 2]));
        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['linkedin_link_1', 'Линк ка LinkedIn профилу:', 'varchar', NULL, 3 ]));
        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['linkedin_link_2', 'Линк ка LinkedIn профилу:', 'varchar', NULL, 4 ]));
        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['linkedin_link_3', 'Линк ка LinkedIn профилу:', 'varchar', NULL, 5 ]));
        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['linkedin_link_4', 'Линк ка LinkedIn профилу:', 'varchar', NULL, 6 ]));
        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['linkedin_link_5', 'Линк ка LinkedIn профилу:', 'varchar', NULL, 7 ]));
        $attributes[] = $grupaTim->addAttribute(self::selectOrCreateAttribute(['linkedin_link_6', 'Линк ка LinkedIn профилу:', 'varchar', NULL, 8 ]));

        return $attributes;
    }

    /**
     * Vraća grupu attributa iz grupe finansiranja i nagrada.
     * @return array
     */
    private static function getFinancingAndPrizesAttributes() {
        $attributes = [];

        $grupaFinansiranjeINagrade = AttributeGroup::get('financing_prizing_group');
        if($grupaFinansiranjeINagrade == null) {
            $grupaFinansiranjeINagrade = AttributeGroup::create(['name' => 'financing_prizing_group', 'label' => 'Finansiranje i nagrade', 'sort_order' => 5]);
        }

        $attributes[] = $grupaFinansiranjeINagrade->addAttribute(self::selectOrCreateAttribute(['prizes', 'Наведите да ли сте добили награде за иновативну идеју: *', 'text', NULL, 1]));
        $attributes[] = $grupaFinansiranjeINagrade->addAttribute(self::selectOrCreateAttribute(['financing_type', 'Наведите како сте финансирали свој развој до сада и како планирате да финансирате развој у будућности (улагање оснивача тима, пријатељи, инвестициони фондови, награде и сл.). Такође, наведите износ расположивих средстава и потребних средстава за развој стартапа, имајући у виду трошкове. * ', 'text', NULL, 2]));
        $attributes[]  =$grupaFinansiranjeINagrade->addAttribute(self::selectOrCreateAttribute(['looking_for_financing', 'Да ли тренутно тражите финансирање? * ', 'bool', NULL, 3]));

        return $attributes;

    }

    /**
     * Vraća grupu poslovni model i pripadajuće atribute.
     * @return array
     */
    private static function getBusinessModelAttributes() {
        $attributes = [];

        $grupaPoslovniModel = AttributeGroup::get('business_model_group');
        if($grupaPoslovniModel == null) {
            $grupaPoslovniModel = AttributeGroup::create(['name' => 'business_model_group', 'label' => 'Poslovni model', 'sort_order' => 6]);
        }

        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['business_model', 'Образложите који модел приходовања планирате или остварујете (продаја производа, лиценци, услуга, модел претплате, франшизе, чланарина, или сл.). Како ћете генерисати приходе? * ', 'text', NULL, 1]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['zarade_zaposlenih_1', 'Zarade zaposlenih', 'varchar', NULL, 2]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['zarade_zaposlenih_2', 'Zarade zaposlenih II godina', 'varchar', NULL, 3]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['fiksni_troskovi_1', 'Fiksni troškovi godina', 'varchar', NULL, 4]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['fiksni_troskovi_2', 'Fiksni troškovi II godina', 'varchar', NULL, 5]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['naknada_angazovanih_1', 'Naknada angažovanih godina', 'varchar', NULL, 6]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['naknada_angazovanih_2', 'Naknada angažovanih II godina', 'varchar', NULL, 7]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_1', 'Knjigovodstvo godina', 'varchar', NULL, 8]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_2', 'Knjigovodstvo II godina', 'varchar', NULL, 9]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['advokat_1', 'Advokat godina', 'varchar', NULL, 10]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['advokat_2', 'Advokat II godina', 'varchar', NULL, 11]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_1', 'Zakup kancelarije godina', 'varchar', NULL, 12]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_2', 'Zakup kancelarije II godina', 'varchar', NULL, 13]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_1', 'Režijski troškovi godina', 'varchar', NULL, 14]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_2', 'Režijski troškovi II godina', 'varchar', NULL, 15]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['ostali_fini_troskovi_1', 'Ostali fini troškovi godina', 'varchar', NULL, 16]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['ostali_fini_troskovi_2', 'Ostali fini troškovi II godina', 'varchar', NULL, 17]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['ukupni_varijabilni_troskovi_1', 'Ukupni varijabilni troškovi godina', 'varchar', NULL, 18]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['ukupni_varijabilni_troskovi_2', 'Ukupni varijabilni troškovi II godina', 'varchar', NULL, 19]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_1', 'Troškovi materijala godina', 'varchar', NULL, 20]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_2', 'Troškovi materijala II godina', 'varchar', NULL, 21]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_1', 'Troškovi alata za rad godina', 'varchar', NULL, 22]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_2', 'Troškovi alata za rad II godina', 'varchar', NULL, 23]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['ostali_varijabilni_troskovi_1', 'Ostali varijabilni troškovi godina', 'varchar', NULL, 24]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['ostali_varijabilni_troskovi_2', 'Ostali varijabilni troškovi II godina', 'varchar', NULL, 25]));
        $attributes[] = $grupaPoslovniModel->addAttribute(self::selectOrCreateAttribute(['finansijski_plan_dokument', 'Finansijski plan', 'file', NULL, 26]));


        return $attributes;

    }

    /**
     * Vraća atribute iz grupe 'preduzetnička preduzetnost'.
     * @return array
     */
    private static function getEnterpreneurReadynessAttributes() {
        $attributes = [];

        $grupaPreduzetnickaSpremnost = AttributeGroup::get('enterpreneur_readyness');
        if($grupaPreduzetnickaSpremnost == null) {
            $grupaPreduzetnickaSpremnost = AttributeGroup::create(['name' => 'enterpreneur_readyness', 'label' => 'Preduzetnička spremnost', 'sort_order' => 6]);
        }

        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['have_skills', 'Које вештине тренутно поседујете и које ћете користити да бисте успешно водили свој бизнис? * ', 'text', NULL, 1]));
        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['improve_skills', 'Које вештине сматрате да треба да унапредите да бисте успешно водили свој бизнис? * ', 'text', NULL, 2]));
        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['regular_menthor_sessions', 'Редовно ћу са менторима радити на развоју свог бизнис плана', 'bool', NULL, 3]));
        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['regular_workshops', 'Редовно ћу похађати радионице релеватне за ваш бизнис ', 'bool', NULL, 4]));
        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['will_evaluate_work', 'Евалуираћу прогрес и рад ', 'bool', NULL, 5]));
        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['establish_company', 'Основаћу привредно друштво у Београду, уколико привредно друштво већ није основана ', 'bool', NULL, 6]));
        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['fulfill_contract_obligations', 'Испуњаваћу све уговорне обавезе ', 'bool', NULL, 7]));
        $attributes[] = $grupaPreduzetnickaSpremnost->addAttribute(self::selectOrCreateAttribute(['motiv', 'Наведите шта вас је мотивисало да се пријавите за инкубацију ? *', 'text', NULL, 8]));

        return $attributes;
    }


}
