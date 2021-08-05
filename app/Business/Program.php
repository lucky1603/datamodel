<?php

namespace App\Business;

use App\Entity;
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
        $entity = $this->getEntity();
        $attributes = self::getAttributesDefinition($programType);
        foreach($attributes as $attribute) {
            $entity->addAttribute($attribute);
        }
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
                $attributes = $attributes->concat(self::getInkubacijaBitfAttributes());
                break;
            case Program::$RASTUCE_KOMPANIJE:
                // Rastuce kompanije

                break;
            default:
                // Neodredjeno

                break;
        }

        return $attributes;
    }

    public static function getInkubacijaBitfAttributes(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['program_name', 'Naziv programa/firme', 'varchar', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['date_of_establishment', 'Datum osnivanja', 'datetime', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['legal_status', 'Pravni status', 'varchar', NULL, 3]));

        $primary_activity = self::selectOrCreateAttribute(['business_branch', 'Osnovna aktivnost', 'select', NULL, 4]);
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

        $attributes->add(self::selectOrCreateAttribute(['pib', 'PIB', 'varchar', NULL, 5]));
        $attributes->add(self::selectOrCreateAttribute(['id_number', 'Matični broj', 'varchar', NULL, 6]));
        $attributes->add(self::selectOrCreateAttribute(['address', 'Adresa', 'varchar', NULL, 7]));
        $attributes->add(self::selectOrCreateAttribute(['number_of_participants', 'Broj angažovanih', 'integer', NULL, 8]));
        $attributes->add(self::selectOrCreateAttribute(['telephone_number', 'Broj telefona', 'varchar', NULL, 9]));
        $attributes->add(self::selectOrCreateAttribute(['email', 'E-mail', 'varchar', ['ui' => 'email'], 10]));
        $attributes->add(self::selectOrCreateAttribute(['web', 'Web adresa', 'varchar', NULL, 11]));



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

        return $attributes;
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
