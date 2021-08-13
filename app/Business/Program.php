<?php

namespace App\Business;

use App\Attribute;
use App\AttributeGroup;
use App\Entity;
use App\Instance;
use \Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Program extends SituationsModel
{
    public static $COLOSSEUM_SPORTS_TECH_SERBIA = 0;
    public static $IMAGINEIF = 1;
    public static $RAISING_STARTS = 2;
    public static $PREDINKUBACIJA = 3;
    public static $INKUBACIJA_NTP = 4;
    public static $INKUBACIJA_BITF = 5;
    public static $RASTUCE_KOMPANIJE = 6;

    /**
     * Constructor with arguments
     * @param $programType - Type of program, integer
     * @param null $data - Array of parameters, if any. Default is null.
     */
    public function __construct($programType, $data = null)
    {
        if(isset($data['instance_id'])) {
            $this->instance = Instance::find($data['instance_id']);
        } else {
            $entity = $this->getEntity();
            $attributeData = self::getAttributesDefinition($programType);

            $attributes = $attributeData['attributes'];
            foreach($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }

            $attributeGroups = $attributeData['attributeGroups'];
            foreach($attributeGroups as $attributeGroup) {
                $entity->attribute_groups()->sync($attributeGroup, false);
            }

            $this->instance = Instance::create(['entity_id' => $entity->id]);
            $this->instance->getTemplateAttributes();

            $this->setData(['program_type' => $programType]);

            $this->setAttributes($data);
        }

    }

    /**
     * Sets the attributes either with data or with the default values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        $programType = $this->getData(['program_type']);
        if($data == NULL) {
            switch($programType) {
                case Program::$INKUBACIJA_BITF:
                    $data = [
                        'program_name' => '',
                        'date_of_establishment' => null,
                        'legal_status' => '',
                        'business_branch' => 0,
                        'pib' => '',
                        'id_number' => '',
                        'address' => '',
                        'number_of_participants' => 0,
                        'telephone_number' => '',
                        'email' => '',
                        'web' => ''
                    ];
                    break;
            }

        }

        $this->setData($data);
    }

    protected function getEntity()
    {
        $entity = Entity::where('name', 'Program')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Program', 'description' => 'Program akceleratora']);
        }

        return $entity;
    }

    public static function find($query=null) {
        if(Entity::where('name', 'Program')->get()->count() == 0) {
            return isset($query) && is_string($query) ? null : collect([]);
        }

        // If it's empty.
        if(!isset($query)) {
            if(Entity::where('name', 'Program')->get()->count() == 0)
                return collect([]);

            $entity_id = Entity::where('name', 'Program')->first()->id;
            $instances = Instance::where(['entity_id' => $entity_id])->get();
            return $instances->map(function($instance) {
                return new Program(0, ['instance_id' => $instance->id]);
            });
        }

        // If it's id.
        if(!is_array($query)) {
            $entity_id = Entity::whereName('Program')->first()->id;
            if ($entity_id == null)
                return null;
            $instance = Instance::where(['id' => $query, 'entity_id' => $entity_id])->first();
            if ($instance == null)
                return null;

            return new Program(0, ['instance_id' => $instance->id]);
        }

        // If it's really array.
        foreach($query as $key => $value) {
            $attribute = Attribute::where('name', $key)->first();
            $tableName = $attribute->type.'_values';

            $entity_id = Entity::all()->where('name', 'Program')->first()->id;
            $temporary_results = DB::table($tableName)->select('instance_id')->where(['value' => $value, 'attribute_id' => $attribute->id])->get();
            $temporary_results = $temporary_results->map(function($item, $key) {
                return $item->instance_id;
            });

            $temporary_results = Instance::all()->whereIn('id', $temporary_results)->where('entity_id', $entity_id);

            if(!isset($results)) {
                $results = $temporary_results;
            } else {
                $results = $temporary_results->intersect($results);
            }

        }

        if($results->count() === 0) {
            return $results;
        }

        $objects = $results->map(function($result, $key) {
            return new static(['instance_id' => $result->id]);
        });

        return $objects;

    }

    public static function getAttributesDefinition($programType): Collection
    {
        $attributes = collect([]);
        $attributeGroups = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['program_type', 'Tip programa', 'integer', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['program_name', 'Ime programa', 'varchar', NULL, 2]));
        switch ($programType) {
            case Program::$COLOSSEUM_SPORTS_TECH_SERBIA:
                // Colosseum

                break;
            case Program::$IMAGINEIF:
                // Imagineif!

                break;
            case Program::$RAISING_STARTS:
                // Raising starts

                break;
            case Program::$PREDINKUBACIJA:
                // Predinkubacija

                break;
            case Program::$INKUBACIJA_NTP:
                // Inkubacija NTP

                break;
            case Program::$INKUBACIJA_BITF:
                // Inkubacija BITF
                $attributeData = self::getInkubacijaBitfAttributesAndGroups();
                $attributeGroups = $attributeGroups->concat($attributeData['attributeGroups']);
                $attributes = $attributes->concat($attributeData['attributes']);

                break;
            case Program::$RASTUCE_KOMPANIJE:
                // Rastuce kompanije

                break;
            default:
                // Neodredjeno

                break;
        }

        return collect([
            'attributeGroups' => $attributeGroups,
            'attributes' => $attributes
        ]);
    }

    /**
     * Get attributes for INKUBACIJA BITF
     * @return Collection
     */
    public static function getInkubacijaBitfAttributesAndGroups(): Collection
    {
        $attributes = collect([]);
        $attributeGroups = collect([]);

        // Opsti podaci.

        $ag_general = AttributeGroup::get('ibitf_general');
        if($ag_general == null) {
            $ag_general = AttributeGroup::create(['name' => 'ibitf_general', 'label' => 'Opšti podaci', 'sort_order' => 1]);
        }

        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['program_name', 'Naziv programa/firme', 'varchar', NULL, 2])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['date_of_establishment', 'Datum osnivanja', 'datetime', NULL, 3])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['legal_status', 'Pravni status', 'varchar', NULL, 4])));

        $primary_activity = $ag_general->addAttribute(self::selectOrCreateAttribute(['business_branch', 'Osnovna aktivnost', 'select', NULL, 5]));
        if(count($primary_activity->getOptions()) == 0) {
            $primary_activity->addOption(['value' => 1, 'text' => 'IoT i pametni gradovi']);
            $primary_activity->addOption(['value' => 2, 'text' => 'Energetska efikasnost, zelene, čiste tehnologije i ekologija']);
            $primary_activity->addOption(['value' => 3, 'text' => 'Вештачка интелигенција, базе података и аналитика']);
            $primary_activity->addOption(['value' => 4, 'text' => 'Veštačka inteligencija, baze podataka i analitika']);
            $primary_activity->addOption(['value' => 5, 'text' => 'Novi materijali i 3 D štampa']);
            $primary_activity->addOption(['value' => 6, 'text' => 'Tehnologija u sportu']);
            $primary_activity->addOption(['value' => 7, 'text' => 'Ekonomske transakcije, finansije, marketing i prodaja']);
            $primary_activity->addOption(['value' => 8, 'text' => 'Robotika i automatizacija']);
            $primary_activity->addOption(['value' => 9, 'text' => 'Turizam i putovanja']);
            $primary_activity->addOption(['value' => 10, 'text' => 'Edukacija , obrazovanje i usavršavanje']);
            $primary_activity->addOption(['value' => 11, 'text' => 'Mediji , komunikacije i društvene mreže/ Gaming i zabava']);
            $primary_activity->addOption(['value' => 12, 'text' => 'Medicinske tehnologije']);
            $primary_activity->addOption(['value' => 13, 'text' => 'Ostalo']);
        }
        $attributes->add($primary_activity);

        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['pib', 'PIB', 'varchar', NULL, 6])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['id_number', 'Matični broj', 'varchar', NULL, 7])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['address', 'Adresa', 'varchar', NULL, 8])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['number_of_participants', 'Broj angažovanih', 'integer', NULL, 9])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['telephone_number', 'Broj telefona', 'varchar', NULL, 10])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['email', 'E-mail', 'varchar', ['ui' => 'email'], 11])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['web', 'Web adresa', 'varchar', NULL, 12])));

        $attributeGroups->add($ag_general);

        // Takmicenja i nagrade.

        $ag_contests = AttributeGroup::get('ibitf_contests');
        if($ag_contests == null) {
            $ag_contests = AttributeGroup::create(['name' => 'ibitf_contests', 'label' => 'Učešće na međunarodnim takmičenjima i konkursima', 'sort_order' => 2]);
        }

        $attributes->add($ag_contests->addAttribute(self::selectOrCreateAttribute(['program_name_contests', 'Naziv programa', 'varchar', NULL, 13])));
        $attributes->add($ag_contests->addAttribute(self::selectOrCreateAttribute(['year', 'Godina', 'integer', NULL, 14])));
        $attributes->add($ag_contests->addAttribute(self::selectOrCreateAttribute(['prizes_and_places', 'Osvojena mesta i nagrade', 'varchar', NULL, 14])));

        $attributeGroups->add($ag_contests);

        // Korisnici finansiranja.

        $ag_financial_users = AttributeGroup::get('ibitf_financial_users');
        if($ag_financial_users == null) {
            $ag_financial_users = AttributeGroup::create([
                'name' => 'ibitf_financial_users',
                'label' => 'Korisnici finansijskih sredstava državnih institucija ili međunarodnih organizacija',
                'sort_order' => 3
            ]);
        }


        $attributes->add($ag_financial_users->addAttribute(self::selectOrCreateAttribute(['institution_name', 'Naziv institucije', 'varchar', NULL, 15])));
        $attributes->add($ag_financial_users->addAttribute(self::selectOrCreateAttribute(['purpose', 'Namena', 'varchar', NULL, 16])));
        $attributes->add($ag_financial_users->addAttribute(self::selectOrCreateAttribute(['amount_din', 'Iznos u din', 'double', NULL, 17 ])));

        $attributeGroups->add($ag_financial_users);

        // Odgovorne osobe.

        $ag_responsible_person = AttributeGroup::get('ibitf_responsible_person');
        if($ag_responsible_person == null) {
            $ag_responsible_person = AttributeGroup::create([
                'name' => 'ibitf_responsible_person',
                'label' => "Odgovorna osoba",
                'sort_order' => 4
            ]);
        }

        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_lastname', 'Prezime', 'varchar', NULL, 18])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_firstname', 'Ime', 'varchar', NULL, 19])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_telephone', 'Telefon', 'varchar', NULL, 20])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_celular', 'Mobilni telefon', 'varchar', NULL, 21])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_email', 'E-mail', 'varchar', ['ui' => 'email'], 22])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_function', 'Funkcija', 'varchar', NULL, 23])));

        $attributeGroups->add($ag_responsible_person);

        // Osnivači.

        $ag_founders = AttributeGroup::get('ibitf_founders');
        if($ag_founders == null) {
            $ag_founders = AttributeGroup::create([
                'name' => 'ibitf_founders',
                'label' => 'Podaci o osnivacima i vlasnicima preduzeća',
                'sort_order' => 5
            ]);
        }

        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_name_1', 'Ime i prezime', 'varchar', NULL, 24])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_university_1', 'Fakultet', 'varchar', NULL, 25])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_share_1', 'Udeo u [%]', 'double', NULL, 26])));

        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_name_2', 'Ime i prezime', 'varchar', NULL, 27])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_university_2', 'Fakultet', 'varchar', NULL, 28])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_share_2', 'Udeo u [%]', 'double', NULL, 29])));

        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_name_3', 'Ime i prezime', 'varchar', NULL, 30])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_university_3', 'Fakultet', 'varchar', NULL, 31])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_share_3', 'Udeo u [%]', 'double', NULL, 32])));

        $attributeGroups->add($ag_founders);

        // About founding of enterprise.

        $ag_founding_enterprise = AttributeGroup::get('ibitf_founding_enterprise');
        if($ag_founding_enterprise == null) {
            $ag_founding_enterprise = AttributeGroup::create([
                'name' => 'ibitf_founding_enterprise',
                'label' => "Ukoliko preduzeće nije osnovano",
                'sort_order' => 6
            ]);
        }

        $attributes->add($ag_founding_enterprise->addAttribute(self::selectOrCreateAttribute(['founding_complany_planned', 'Da li planirate osnivanje preduzeća?', 'bool', NULL, 33])));
        $attributes->add($ag_founding_enterprise->addAttribute(self::selectOrCreateAttribute(['founding_act_prepared', "Osnivački akt pripremljen", 'bool', NULL, 34])));
        $attributes->add($ag_founding_enterprise->addAttribute(self::selectOrCreateAttribute(['founding_act_in_preparation', 'Osnivački akt u pripremi', 'bool', NULL, 35])));

        $attributeGroups->add($ag_founding_enterprise);

        // Ostali bitni podaci

        $ag_general_2 = AttributeGroup::get('ibitf_general_2');
        if($ag_general_2 == null) {
            $ag_general_2 = AttributeGroup::create([
                'name' => 'ibitf_general_2',
                'label' => "Ostali podaci",
                'sort_order' =>  7
            ]);
        }

        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['program_project_name', 'Naziv projekta/programa', 'text', NULL, 36])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['program_project_description', "Kratak opis programa", 'text', NULL, 37])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['problem_solving', 'Problem koji rešavate', 'text', NULL, 38])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['solutions', 'Rešenja', 'text', NULL, 39])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['development_phase', 'Faza razvoja', 'text', NULL, 40])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['team', 'Tim i organizacija rada', 'text', NULL, 41])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['target_groups', 'Ciljne grupe', 'text', NULL, 42])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['market', 'Tržište', 'text', NULL, 43])));

        $attributeGroups->add($ag_general_2);

        // Troškovi

        $ag_expenses = AttributeGroup::get('ibitf_expenses');
        if($ag_expenses == null) {
            $ag_expenses = AttributeGroup::create([
                'name' => 'ibitf_expenses',
                'label' => 'Troškovi',
                'sort_order' => 8
            ]);
        }

        //// Trokovi - godina 1

        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_1_g1', 'Zarada zaposleni 1', 'double', NULL, 44])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_2_g1', 'Zarada zaposleni 2', 'double', NULL, 45])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_1_g1', 'Naknada angazovani 1', 'double', NULL, 46])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_2_g1', 'Naknada angazovani 2', 'double', NULL, 47])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_g1', 'Knjigovodstvo', 'double', NULL, 48])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['Advokati_g1', 'Advokati', 'double', NULl, 49])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_g1', 'Zakup kancelarije', 'double', NULL, 50])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_g1', 'Režijski troškovi', 'double', NULL, 51])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_fiksni_troskovi_g1', 'Ostali fiksni troškovi', 'double', NULL, 52])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_g1', 'Troškovi materijala', 'double', NULL, 53])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_za_rad_g1', 'Troškovi alata za rad', 'double', NULL, 54])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_troskovi_g1', 'Ostali troškovi', 'double', NULL, 55])));

        //// Trokovi - godina 2

        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_1_g2', 'Zarada zaposleni 1', 'double', NULL, 56])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_2_g2', 'Zarada zaposleni 2', 'double', NULL, 57])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_1_g2', 'Naknada angazovani 1', 'double', NULL, 58])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_2_g2', 'Naknada angazovani 2', 'double', NULL, 59])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_g2', 'Knjigovodstvo', 'double', NULL, 60])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['Advokati_g2', 'Advokati', 'double', NULl, 61])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_g2', 'Zakup kancelarije', 'double', NULL, 62])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_g2', 'Režijski troškovi', 'double', NULL, 63])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_fiksni_troskovi_g2', 'Ostali fiksni troškovi', 'double', NULL, 64])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_g2', 'Troškovi materijala', 'double', NULL, 65])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_za_rad_g2', 'Troškovi alata za rad', 'double', NULL, 66])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_troskovi_g2', 'Ostali troškovi', 'double', NULL, 67])));

        //// Trokovi - godina 3

        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_1_g3', 'Zarada zaposleni 1', 'double', NULL, 68])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_2_g3', 'Zarada zaposleni 2', 'double', NULL, 69])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_1_g3', 'Naknada angazovani 1', 'double', NULL, 70])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_2_g3', 'Naknada angazovani 2', 'double', NULL, 71])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_g3', 'Knjigovodstvo', 'double', NULL, 72])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['Advokati_g3', 'Advokati', 'double', NULl, 73])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_g3', 'Zakup kancelarije', 'double', NULL, 74])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_g3', 'Režijski troškovi', 'double', NULL, 75])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_fiksni_troskovi_g3', 'Ostali fiksni troškovi', 'double', NULL, 76])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_g3', 'Troškovi materijala', 'double', NULL, 77])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_za_rad_g3', 'Troškovi alata za rad', 'double', NULL, 78])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_troskovi_g3', 'Ostali troškovi', 'double', NULL, 79])));

        $attributeGroups->add($ag_expenses);

        // Prihodi
        $ag_generate_income = AttributeGroup::get('ibitf_generate_income');
        if($ag_generate_income == null) {
            $ag_generate_income = AttributeGroup::create([
                'name' => 'ibitf_generate_income',
                'label' => 'Generisanje prihoda',
                'sort_order' => 9
            ]);
        }

        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['generating_income', 'Generisanje prihoda', 'text', NULL, 80])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['available_assets', 'Raspoloživa sredstva', 'double', NULL, 81])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['needed_assets', 'Potrebna sredstva', 'double', NULL, 82])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['own_assets', 'Sopstvena sredstva', 'double', NULL, 83])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['credits', 'Krediti/drugi izvori', 'double', NULL, 84])));

        $attributeGroups->add($ag_generate_income);

        // Infrastrukturne usluge.

        $ag_infrastructure = AttributeGroup::get('ibitf_infrastructure');
        if($ag_infrastructure == null) {
            $ag_infrastructure = AttributeGroup::create([
                'name' => 'ibitf_infrastructure',
                'label' => 'Potrebne infrastukturne i stručne usluge',
                'sort_order' => 10
            ]);
        }

        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['office_space', 'Kancelarijski poslovni prostor [m2]', 'double', NULL, 85])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['administrative_services', 'Administrativne usluge', 'bool', NULL, 86])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['bookkeeping_services', 'Knjigovodstvene usluge', 'bool', NULL, 87])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['legal_services', 'Pravne usluge', 'bool', NULL, 88])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['other_services', 'Ostale usluge, navedite koje:', 'varchar', NULL, 89])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['consulting_services', 'Konsalting usluge, trening i mentoring program', 'bool', NULL, 90])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['specific_needs', 'Navedite specifične potrebe ukoliko imate', 'varchar', NULL, 91])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['promotion_services', 'Usluge promocije', 'bool', NULL, 92])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['connection_services', 'Usluge povezivanja i umrežavanja', 'bool', NULL, 93])));

        $attributeGroups->add($ag_infrastructure);

        $ag_attachments = AttributeGroup::get('ibitf_attachments');
        if($ag_attachments == null) {
            $ag_attachments = AttributeGroup::create([
                'name' => 'ibitf_attachments',
                'label' => 'Prilozi',
                'sort_order' => 11
            ]);
        }

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute(
        [
            'resenje_apr_link',
            'Link sa APR gde se može preuzeti rešenje o registraciji privrednog društva, ako ga ima.',
            'varchar',
            NULL,
            94
        ])));

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute([
            'resenje_fajl',
            'Dokument/rešenje o registraciji privrednog društva',
            'file',
            NULL,
            95
        ])));

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute([
            'linkedin_founders',
            'Linkovi ka Linkedin profilima, ukoliko postoje, za svako lice',
            'text',
            NULL,
            96
        ])));

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute([
            'founders_cv',
            'Fajl sa kratkim biografijama svih osnivača',
            'file',
            NULL,
            97
        ])));

        $attributeGroups->add($ag_attachments);

        return collect(
            [
                'attributes' => $attributes,
                'attributeGroups' => $attributeGroups
            ]);
    }

    public static function getRastuceAttributes() {
        $attributes = collect([]);

        return $attributes;
    }

    public static function getRaisingStartsAttributes() {
        $attributes = collect([]);

        return $attributes;
    }

    public function getAttributeGroups()
    {
        $groups = collect([]);
        if($this->getAttribute('program_type')->getValue() == Program::$INKUBACIJA_BITF) {
            $groups->add(AttributeGroup::get('ibitf_general'));
            $groups->add(AttributeGroup::get('ibitf_contests'));
            $groups->add(AttributeGroup::get('ibitf_financial_users'));
            $groups->add(AttributeGroup::get('ibitf_responsible_person'));
            $groups->add(AttributeGroup::get('ibitf_founders'));
            $groups->add(AttributeGroup::get('ibitf_founding_enterprise'));
            $groups->add(AttributeGroup::get('ibitf_general_2'));
            $groups->add(AttributeGroup::get('ibitf_expenses'));
            $groups->add(AttributeGroup::get('ibitf_generate_income'));
            $groups->add(AttributeGroup::get('ibitf_infrastructure'));
            $groups->add(AttributeGroup::get('ibitf_attachments'));
        }

        return $groups;
    }
}
