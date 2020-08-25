<?php


namespace App\Business;


use App\Attribute;
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

    public function addSituationByData($situationType, $params) {
        $data = [];
        switch($situationType) {
            case 'interesovanje':
                $situation = new Situation();
                $application_form = Attribute::where('name', 'application_form')->first();
                if(!$application_form) {
                    $application_form = Attribute::create(['name' => 'application_form', 'label' => 'Obrazac za prijavu', 'type' => 'file']);
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
                        self::selectOrCreateAttribute(['application_form', 'Obrazac za prijavu','file'])
                    ],[
                        $data['application_form']
                    ]);
                }

                if(isset($data['client'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['client', 'Klijent', 'varchar'])
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
                        self::selectOrCreateAttribute(['eval_date', 'Datum evaluacije', 'datetime'])
                    ],[
                        $data['eval_date']
                    ]);
                }

                // Prosecna ocena.
                if(isset($data['mark'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['mark', 'Prosečna ocena', 'double'])
                    ],[
                        $data['mark']
                    ]);
                }

                $data['decision'] = $data['decision'] == 'da';

                // Odluka
                if(isset($data['decision'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['decision', 'Da li je prošao', 'bool'])
                    ],[
                        $data['decision']
                    ]);
                }

                // Primedba.
                if(isset($data['remark'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['remark', 'Primedba komisije', 'text'])
                    ],[
                        $data['remark']
                    ]);
                }

                // Fajl koji je koriscen za procenu.
                if(isset($data['assertion_file'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['assertion_file', 'Fajl za evaluaciju','file'])
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
                        self::selectOrCreateAttribute(['meeting_date', 'Datum sastanka','datetime'])
                    ],[
                        $data['meeting_date']
                    ]);
                }

                // Mesto sastanka.
                if(isset($data['meeting_place'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_place', 'Mesto sastanka','varchar'])
                    ],[
                        $data['meeting_place']
                    ]);
                }

                // Prisutni na sastanku
                if(isset($data['meeting_participants'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_participants', 'Prisutni na sastanku','text'])
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

                foreach($params as $key => $value) {
                    $data[$key] = $value;
                }


                // Datum sastanka.
                if(isset($data['meeting_date'])) {
                    $situation->addExtraAttributes([
                        self::selectOrCreateAttribute(['meeting_date', 'Datum sastanka','datetime'])
                    ],[
                        $data['meeting_date']
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
                        'type' => 'text'
                    ]);
                }
                $situation->addAttribute($razlog_odbijanja);

                $datum_sednice = Attribute::where('name', 'datum_sednice')->first();
                if(!$datum_sednice) {
                    $datum_sednice = Attribute::create([
                        'name' => 'datum_sednice',
                        'label' => 'Datum zasedanja komisije',
                        'type' => 'datetime'
                    ]);
                }
                $situation->addAttribute($datum_sednice);
                $data = [
                    'name' => $situationType,
                    'description' => 'Klijent je odbijen',
                    'sender' => 'NTP Beograd',
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
     * Returns the collection of attributes typical for this type of instance.
     * @return array Attributes array.
     */
    public static function getAttributesDefinition($filter=null) {
        $attributes = [];

        // Name.
        $attributes[] = self::selectOrCreateAttribute(['name', 'Naziv', 'varchar']);

        // Contact person.
        $attributes[] = self::selectOrCreateAttribute(['contact_person', 'Osoba za kontakt', 'varchar']);

        // E-mail
        $attributes[] = self::selectOrCreateAttribute(['email', 'E-mail', 'varchar', 'email']);

        // Password
        $attributes[] = self::selectOrCreateAttribute(['password', 'Lozinka', 'varchar', 'password']);

        // Telephone.
        $attributes[] = self::selectOrCreateAttribute(['telephone', 'Telefon', 'varchar']);

        // University.
        $attributes[] = self::selectOrCreateAttribute(['university', 'Fakultet', 'varchar']);

        // Date interested.
        $attributes[] = self::selectOrCreateAttribute(['date_interested', 'Datum interesovanja', 'datetime']);

        // Short inovation desc.
        $attributes[] = self::selectOrCreateAttribute(['ino_desc', 'Kratak opis inovacije', 'text']);

        // Why contact us?
        $reason_contact = self::selectOrCreateAttribute(['reason_contact', 'Zašto nas kontaktirate?', 'select']);
        if(count($reason_contact->getOptions()) == 0) {
            $reason_contact->addOption(['value' => 1, 'text' => 'Opcija 1']);
            $reason_contact->addOption(['value' => 2, 'text' => 'Opcija 2']);
            $reason_contact->addOption(['value' => 3, 'text' => 'Opcija 3']);
        }
        $attributes[] = $reason_contact;

        // Notes (mi unosimo)
        $attributes[] = self::selectOrCreateAttribute(['notes', 'Naša napomena', 'text']);

        if(isset($filter) && $filter === 'start')
            return $attributes;

        // Is is registered?
        $attributes[] = self::selectOrCreateAttribute(['is_registered', 'Da li je registrovan(a)', 'bool']);

        // Fields of interest
        $fields_of_interest = self::selectOrCreateAttribute(['interests', 'Oblast poslovanja', 'select']);
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

        // Napomena (oni unose)
        $attributes[] = self::selectOrCreateAttribute(['remark', 'Napomena kandidata', 'text']);

        // Status člana.
        $status = self::selectOrCreateAttribute(['status', 'Status člana', 'select']);
        if(count($status->getOptions()) == 0) {
            $status->addOption(['value' => 1, 'text' => 'Zainteresovan']);
            $status->addOption(['value' => 2, 'text' => 'Prijavljen']);
            $status->addOption(['value' => 3, 'text' => 'Pre-selektovan']);
            $status->addOption(['value' => 4, 'text' => 'Pozvan na sastanak']);
            $status->addOption(['value' => 5, 'text' => 'Datum sastanka potvrđen']);
            $status->addOption(['value' => 6, 'text' => 'Prihvaćena prijava']);
            $status->addOption(['value' => 7, 'text' => 'Odbijena prijava']);
            $status->addOption(['value' => 8, 'text' => 'Dodeljen prostor']);
            $status->addOption(['value' => 9, 'text' => 'Potpisan ugovor']);
        }
        $attributes[] = $status;

        // Program.
        $program = self::selectOrCreateAttribute(['program', 'Program', 'select']);
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
        $attributes[] = $program;

        // Vrsta članstva
        $membership = self::selectOrCreateAttribute(['membership', 'Članstvo', 'select']);
        if(count($membership->getOptions()) == 0) {
            $membership = Attribute::create(['name' => 'membership', 'label' => 'Članstvo', 'type' => 'select']);
            $membership->addOption(['value' => 1, 'text' => 'Virtuelni član']);
            $membership->addOption(['value' => 2, 'text' => 'Punopravni član']);
            $membership->addOption(['value' => 3, 'text' => 'Alumni']);

        }
        $attributes[] = $membership;

        // Prijava za članstvo - dokument.
        $attributes[] = self::selectOrCreateAttribute(['application_form', 'Obrazac za prijavu', 'file']);

        return $attributes;
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
            isset($this->data['date_interested']) ? $this->data['date_interested'] : now()
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

        $this->instance->attributes->where('name', 'application_form')->first()->setValue(
            isset($this->data['application_form']) ? $this->data['application_form'] : [
                'filename' => '',
                'filelink' => '',
            ]
        );

    }

    /**
     * Attaches user to the client.
     * @param $user
     */
    public function attachUser($user) {
        $this->instance->attachUser($user);
    }


}
