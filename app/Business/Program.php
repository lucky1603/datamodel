<?php

namespace App\Business;

use App\AttributeGroup;
use App\Entity;
use App\Instance;
use \Illuminate\Support\Collection;

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
            $this->entity = $this->getEntity();
            $attributeData = self::getAttributesDefinition($programType);

            $attributes = $attributeData['attributes'];
            foreach($attributes as $attribute) {
                $this->entity->addAttribute($attribute);
            }

            $attributeGroups = $attributeData['attributeGroups'];
            foreach($attributeGroups as $attributeGroup) {
                $this->entity->attribute_groups()->sync($attributeGroup, false);
            }

            $this->instance = Instance::create(['entity_id' => $this->entity->id]);
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

    public static function getAttributesDefinition($programType): Collection
    {
        $attributes = collect([]);
        $attributeGroups = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['program_type', 'Tip programa', 'integer', NULL, 1]));
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

    public static function getInkubacijaBitfAttributesAndGroups(): Collection
    {
        $attributes = collect([]);
        $attributeGroups = collect([]);

        $ag_general = AttributeGroup::get('ibtf_general');
        if($ag_general == null) {
            $ag_general = AttributeGroup::create(['name' => 'ibtf_general', 'label' => 'Opšti podaci', 'sort_order' => 1]);
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

//        $attributes->add(self::selectOrCreateAttribute(['naziv_programa_dk', 'Naziv programa', 'varchar', NULl, 12]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));
//        $attributes->add(self::selectOrCreateAttribute([]));

        $attributeGroups->add($ag_general);

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
}
