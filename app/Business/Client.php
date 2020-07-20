<?php


namespace App\Business;


use App\Attribute;
use App\Entity;
use App\Instance;
use Illuminate\Support\Facades\DB;

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
                $data = [
                    'name' => 'Situation - Interesovanje',
                    'sender' => $this->getData(['name']),
                ];

                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                $situation = new Situation($data);
                $this->addSituation($situation);
                break;
            case 'registracija':
                $data = [
                   'name' => 'Situation - registracija',
                   'sender' => $this->getData(['name'])
                ];

                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
                }

                $situation = new Situation($data);
                $this->addSituation($situation);
                break;
            case 'evaluacija':
                $situation = new Situation();
                $datumEvaluacije = Attribute::where('name', 'eval_date')->first();
                if(!$datumEvaluacije) {
                    $datumEvaluacije = Attribute::create([
                        'name' => 'eval_date',
                        'label' => 'Datum evaluacije',
                        'type' => 'datetime'
                    ]);
                }
                $situation->addAttribute($datumEvaluacije);
                $data = [
                    'name' => 'Situation - Zakazan datum evaluacije',
                    'sender' => $this->getData(['name']),
                    'eval_date' => isset($params['eval_date']) ? params['eval_date'] : now()
                ];

                if(isset($params)) {
                    foreach($params as $key => $value) {
                        $data[$key] = $value;
                    }
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
                    'name' => 'Situation - odbijanje kandidature',
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
    public static function getAttributesDefinition() {
        $attributes = [];

        // Name.
        $name = Attribute::where('name','name')->first();
        if(!isset($name)) {
            $name = Attribute::create(['name' => 'name', 'label' => 'Naziv', 'type' => 'varchar']);
        }
        $attributes[] = $name;

        // Is is registered?
        $is_registered = Attribute::where('name', 'is_registered')->first();
        if(!$is_registered) {
            $is_registered = Attribute::create(['name' => 'is_registered', 'label' => 'Da li je registrovana', 'type' => 'bool']);
        }
        $attributes[] = $is_registered;

        // Contact person.
        $contact_person = Attribute::where('name', 'contact_person')->first();
        if(!$contact_person) {
            $contact_person = Attribute::create(['name' => 'contact_person', 'label' => 'Kontakt osoba', 'type' => 'varchar']);
        }
        $attributes[] = $contact_person;

        // E-mail
        $email = Attribute::where('name', 'email')->first();
        if(!$email) {
            $email = Attribute::create(['name' => 'email', 'label' => 'E-mail', 'type' => 'varchar']);
        }
        $attributes[] = $email;

        // Telephone.
        $telephone = Attribute::where('name', 'telephone')->first();
        if(!$telephone) {
            $telephone = Attribute::create(['name' => 'telephone', 'label' => 'Telefon', 'type' => 'varchar']);
        }
        $attributes[] = $telephone;

        // University.
        $university = Attribute::where('name', 'university')->first();
        if(!$university) {
            $university = Attribute::create(['name' => 'university', 'label' => 'Fakultet', 'type' => 'varchar']);
        }
        $attributes[] = $university;

        // Date interested.
        $date_interested = Attribute::where('name', 'date_interested')->first();
        if(!$date_interested) {
            $date_interested = Attribute::create(['name' => 'date_interested', 'label' => 'Datum interesovanja', 'type' => 'datetime']);
        }
        $attributes[] = $date_interested;

        // Fields of interest
        $fields_of_interest = Attribute::where('name', 'interests')->first();
        if(!$fields_of_interest) {
            $fields_of_interest = Attribute::create(['name' => 'interests', 'label' => 'Polja interesovanja', 'type' => 'select', 'extra' => 'multiselect']);
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

        // Short inovation desc.
        $ino_desc = Attribute::where('name', 'ino_desc')->first();
        if(!$ino_desc) {
            $ino_desc = Attribute::create(['name' => 'ino_desc', 'label' => 'Opis inovacije', 'type' => 'text']);
        }
        $attributes[] = $ino_desc;

        // Why contact us?
        $reason_of_contact = Attribute::where('name', 'reason_contact')->first();
        if(!$reason_of_contact) {
            $reason_of_contact = Attribute::create(['name' => 'reason_contact', 'label' => 'Zašto nas kontaktirate?', 'type' => 'text']);
        }
        $attributes[] = $reason_of_contact;

        // Napomena (oni unose)
        $remark = Attribute::where('name', 'remark')->first();
        if(!$remark) {
            $remark = Attribute::create(['name' => 'remark', 'label' => 'Napomena kandidata', 'type' => 'text']);
        }
        $attributes[] = $remark;

        // Notes (mi unosimo)
        $notes = Attribute::where('name', 'notes')->first();
        if(!$notes) {
            $notes = Attribute::create(['name' => 'notes', 'label' => 'Naša napomena', 'type' => 'text']);
        }
        $attributes[] = $notes;

        // Status člana.
        $status = Attribute::where('name', 'status')->first();
        if(!$status) {
            $status = Attribute::create(['name' => 'status', 'label' => 'Status člana', 'type' => 'select']);
            $status->addOption(['value' => 1, 'text' => 'Zainteresovan']);
            $status->addOption(['value' => 2, 'text' => 'Prijavljen']);
            $status->addOption(['value' => 3, 'text' => 'Pre-selektovan']);
            $status->addOption(['value' => 4, 'text' => 'Prihvaćena prijava']);
            $status->addOption(['value' => 5, 'text' => 'Odbijena prijava']);
        }
        $attributes[] = $status;

        // Program.
        $program = Attribute::where('name', 'program')->first();
        if(!$program) {
            $program = Attribute::create(['name' => 'program', 'label' => 'Program', 'type' => 'select']);
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
        $membership = Attribute::where('name', 'membership')->first();
        if(!$membership) {
            $membership = Attribute::create(['name' => 'membership', 'label' => 'Članstvo', 'type' => 'select']);
            $membership->addOption(['value' => 1, 'text' => 'Virtuelni član']);
            $membership->addOption(['value' => 2, 'text' => 'Punopravni član']);
            $membership->addOption(['value' => 3, 'text' => 'Alumni']);

        }
        $attributes[] = $membership;

        // Prijava za članstvo - dokument.
        $application_form = Attribute::where('name', 'application_form')->first();
        if(!$application_form) {
            $application_form = Attribute::create(['name' => 'application_form', 'label' => 'Obrazac za prijavu', 'type' => 'file']);
        }
        $attributes[] = $application_form;

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

}
