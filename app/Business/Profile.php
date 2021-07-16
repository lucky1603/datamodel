<?php


namespace App\Business;


use App\Attribute;
use App\Entity;
use App\Instance;
use Illuminate\Support\Facades\DB;

class Profile extends BusinessModel
{
    ///
    /// GENERAL PART
    ///

    /**
     * Gets the entity template.
     */
    protected function getEntity()
    {
        $entity = Entity::where('name', 'Profile')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Profile', 'description' => 'Client Profile']);
            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    protected function setAttributes()
    {
        $data = [
            'name' => '',
            'is_company' => false,
            'id_number' => '',
            'contact_person' => '',
            'contact_email' => '',
            'contact_phone' => '',
            'university' => 0,
            'short_ino_desc' => '',
            'business_branch' => 0,
            'reason_contact' => 0,
            'note' => '',
            'profile_status' => 0,
        ];

        $this->setData($data);
    }

    ///
    /// Static methods
    ///

    /**
     * Gets the attributes collection for this type of entity.
     * @return array
     */
    public static function getAttributesDefinition(): array
    {
        $attributes = [];

        $attributes[] = self::selectOrCreateAttribute(['name', 'Naziv', 'varchar', NULL, 1]);
        $attributes[] = self::selectOrCreateAttribute(['is_company', 'Da li je kompanija', 'bool', NULL, 2]);
        $attributes[] = self::selectOrCreateAttribute(['id_number', 'Maticni broj', 'varchar', NULL, 3]);
        $attributes[] = self::selectOrCreateAttribute(['contact_person', 'Kontakt osoba', 'varchar', NULL, 4]);
        $attributes[] = self::selectOrCreateAttribute(['contact_email', 'E-mail adresa', 'varchar', NULL, 5]);
        $attributes[] = self::selectOrCreateAttribute(['contact_phone', 'Telefon', 'varchar', NULL, 6]);

        $university = self::selectOrCreateAttribute(['university', 'Fakultet', 'select', NULL, 7]);
        if(count($university->getOptions()) == 0) {
            $university->addOption(['value' => 0, 'text' => 'NEMA']);
            $university->addOption(['value' => 1, 'text' => 'Arhitektonski fakultet - Beograd']);
            $university->addOption(['value' => 2, 'text' => 'Elektrotehnički fakultet - Beograd']);
            $university->addOption(['value' => 3, 'text' => 'Pravni fakultet - Beograd']);
            $university->addOption(['value' => 4, 'text' => 'Šumarski fakultet - Beograd']);
        }
        $attributes[] = $university;

        $attributes[] = self::selectOrCreateAttribute(['short_ino_desc', 'Kratak opis inovacije', 'text', NULL, 8]);

        $business_branch = self::selectOrCreateAttribute(['business_branch', 'Oblast poslovanja', 'select', NULL, 9]);
        if(count($business_branch->getOptions()) == 0) {
            $business_branch->addOption(['value' => 0, 'text' => 'Drugo']);
            $business_branch->addOption(['value' => 1, 'text' => 'IoT i pametni gradovi']);
            $business_branch->addOption(['value' => 2, 'text' => 'Energetska efikasnost, zelene, čiste tehnologije i ekologija']);
            $business_branch->addOption(['value' => 3, 'text' => 'Вештачка интелигенција, базе података и аналитика']);
            $business_branch->addOption(['value' => 4, 'text' => 'Veštačka inteligencija, baze podataka i analitika']);
            $business_branch->addOption(['value' => 5, 'text' => 'Novi materijali i 3 D štampa']);
            $business_branch->addOption(['value' => 6, 'text' => 'Tehnologija u sportu']);
            $business_branch->addOption(['value' => 7, 'text' => 'Ekonomske transakcije, finansije, marketing i prodaja']);
            $business_branch->addOption(['value' => 8, 'text' => 'Robotika i automatizacija']);
            $business_branch->addOption(['value' => 9, 'text' => 'Turizam i putovanja']);
            $business_branch->addOption(['value' => 10, 'text' => 'Edukacija , obrazovanje i usavršavanje']);
            $business_branch->addOption(['value' => 11, 'text' => 'Mediji , komunikacije i društvene mreže/ Gaming i zabava']);
            $business_branch->addOption(['value' => 12, 'text' => 'Medicinske tehnologije']);
            $business_branch->addOption(['value' => 13, 'text' => 'Ostalo']);
        }
        $attributes[] = $business_branch;

        $reason_contact = self::selectOrCreateAttribute(['reason_contact', 'Razlog kontaktiranja', 'select', NULL, 10]);
        if(count($reason_contact->getOptions()) == 0) {
            $reason_contact->addOption(['value' => 0, 'text' => 'Drugo']);
            $reason_contact->addOption(['value' => 1, 'text' => 'Razlog 1']);
            $reason_contact->addOption(['value' => 2, 'text' => 'Razlog 2']);
            $reason_contact->addOption(['value' => 3, 'text' => 'Razlog 3']);
        }
        $attributes[] = $reason_contact;

        $attributes[] = self::selectOrCreateAttribute(['note', 'Napomena', 'text', NULL, 11]);

        $status = self::selectOrCreateAttribute(['profile_status', 'Status profila', 'select', NULL, 12]);
        if(count($status->getOptions()) == 0) {
            $status->addOption(['value' => 0, 'text' => 'Neinicijalizovan']);
            $status->addOption(['value' => 1, 'text' => 'Mapiran/Kontaktiran']);
            $status->addOption(['value' => 2, 'text' => 'Zainteresovan']);
            $status->addOption(['value' => 3, 'text' => 'Prijavljen']);
            $status->addOption(['value' => 4, 'text' => 'Pre-selektovan']);
            $status->addOption(['value' => 5, 'text' => 'Prihvaćena prijava']);
            $status->addOption(['value' => 4, 'text' => 'Odbijena prijava']);
        }
        $attributes[] = $status;

        return $attributes;
    }

    ///
    /// Situations
    ///

    public function getSituations() {
        return collect([]);
    }

}
