<?php

namespace App\Business;

use App\AttributeGroup;
use Illuminate\Support\Collection;

class RastuceProgram extends Program
{
    public function getAttributeGroups() {
        $groups = collect([]);

        $groups->add(AttributeGroup::get('rastuce_general'));
        $groups->add(AttributeGroup::get('rastuce_tim'));
        $groups->add(AttributeGroup::get('rastuce_razvoj_trzista'));
        $groups->add(AttributeGroup::get('rastuce_rast_godisnji'));
        $groups->add(AttributeGroup::get('rastuce_saradnja_nio'));
        $groups->add(AttributeGroup::get('rastuce_potpis'));

        return $groups;
    }

    public function initWorkflow() {
        if($this->getWorkflow() == null) {
            $this->setWorkflow(new RastuceWorkflow());
        }
        $this->workflow->setCurrentIndex($this->getStatus() - 1);
    }

    protected function updateProgramData() {
        $this->setData([
            'program_type' => Program::$RASTUCE_KOMPANIJE,
            'program_name' => __('Rastuće Kompanije'),
            'program_status' => 1,
        ]);
    }

    protected function setAttributes($data = null)
    {
        // set default values.
        if($data == null) {
            $data = [
                'program_type' => Program::$RASTUCE_KOMPANIJE,
                'program_name' => __('Rastuće Kompanije'),
                'program_status' => 1
            ];
        }

        $this->setData($data);
    }

    protected function getTextForStatus($status): string
    {
        switch($status) {
            case 1:
                return __('Application');
            case 4:
                return __('Contract');
            default:
                return parent::getTextForStatus($status);
        }
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributeData = parent::getAttributesDefinition();
        $attributes = $attributeData['attributes'];
        $attributeGroups = $attributeData['attributeGroups'];

        // Opsti podaci
        $ag_general = AttributeGroup::get('rastuce_general');
        if($ag_general == null) {
            $ag_general = AttributeGroup::create(['name' => 'rastuce_general', 'label' => "Opšti podaci", 'sort_order' => 1]);
        }

        $attributeGroups[] = $ag_general;

        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['company_name', "Naziv kompanije", 'varchar', NULL, 1])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['id_number', "Matični broj", 'varchar', NULL, 2])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['founding_date', "Datum osnivanja", 'datetime', NULL, 3])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['webpage', "Internet stranica", 'varchar', NULL, 4])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['business_branch', "Sektor/Oblast/Industrija", 'select', NULL, 5])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['responsible_person', "Odgovorno lice", 'varchar', NULL, 6])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['contact', "Kontakt", 'varchar', NULL, 7])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['innovative_product', "Inovativni proizvod ili tehnologija", 'varchar', NULL, 8])));

        // Tim
        $ag_tim = AttributeGroup::get('rastuce_tim');
        if($ag_tim == null) {
            $ag_tim = AttributeGroup::create(['name' => 'rastuce_tim', 'label' => "Tim", 'sort_order' => 2]);
        }

        $attributeGroups[] = $ag_tim;

        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['team_description', 'Da li je tim uspostavljen i razvijen?', 'text', NULL, 9])));

        // Razvoj inovativnog proizvoda ili tehnologije
        $ag_innovative = AttributeGroup::get('rastuce_inovative');
        if($ag_innovative == null) {
            $ag_innovative = AttributeGroup::create(['name' => 'rastuce_inovative', 'label' => "Razvoj inovativnog proizvoda ili tehnologije", 'sort_order' => 2]);
        }
        $attributeGroups[] = $ag_innovative;

        $innovative_phase = self::selectOrCreateAttribute(['innovative_phase', 'U kojoj ste fazi razvoja inovativnog proizvoda ili tehnologije', 'select', 'multiselect', 10]);
        if(count($innovative_phase->getOptions()) == 0) {
            $innovative_phase->addOption(["value" => 1, 'text' => 'Ideja ili nacrt']);
            $innovative_phase->addOption(["value" => 2, 'text' => 'Prototip u laboratoriji ili eksperimentalnom okruženju']);
            $innovative_phase->addOption(["value" => 3, 'text' => 'Testiran prototip']);
            $innovative_phase->addOption(["value" => 4, 'text' => 'Minimalno održivi proizvod - MVP']);
            $innovative_phase->addOption(["value" => 5, 'text' => 'Ideja ili nacrt']);
        }

        $attributes->add($ag_innovative->addAttribute($innovative_phase));
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['product_developed', 'Da li su inovativni proizvod ili tehnologija razvijeni?', 'text', NULL, 11])));
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['innovation_grade', 'Opišite stepen inovativnosti tehnologije', 'text', NULL, 12])));
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['intellectual_property_protected', 'Da li kompanija ima zaštićena prava intelektualne svojine?', 'text', NULL, 13])));

        // Razvoj tržišta i komercijalizacija
        $ag_marketdev = AttributeGroup::get('rastuce_razvoj_trzista');
        if($ag_marketdev == null) {
            $ag_marketdev = AttributeGroup::create(['name' => 'rastuce_razvoj_trzista', 'label' => "Razvoj tržišta i komercijalizacija", 'sort_order' => 3]);
        }
        $attributeGroups[] = $ag_marketdev;

        $commercial_phase = self::selectOrCreateAttribute(['commercial_phase', 'U kojoj ste komercijalizacije inovativnog proizvoda ili tehnologije', 'select', 'multiselect', 14]);
        if(count($innovative_phase->getOptions()) == 0) {
            $innovative_phase->addOption(["value" => 1, 'text' => 'Ostvareni prvi kontakti sa ciljnom grupom']);
            $innovative_phase->addOption(["value" => 2, 'text' => 'Potvrđena potreba i ciljna grupa']);
            $innovative_phase->addOption(["value" => 3, 'text' => 'Komercijalizovan proizvod sa uspostavljenim partnerstvima i prvim kupcima']);
            $innovative_phase->addOption(["value" => 4, 'text' => 'Definisana strategija rasta i poslovanje na više tržišta']);
        }

        $attributes->add($ag_marketdev->addAttribute($commercial_phase));
        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(['problem_desc', 'Opišite koji problem na tržištu rešavate inovativnim proizvodom ili tehnologijom', 'text', NULL, 15])));
        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(
            [
                'solution_advantage',
                'Opišite jedinstvenu prednost rešenja u odnosu na postojeća (indirektna i direktna konkurencija) i šta vaše rešenje čini inovativnim sa stanovišta poslovanja.',
                'text',
                NULL,
                16
            ])));

        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(
            [
                'product_commercialized',
                'Da li su proizvod ili tehnologija komercijalizovani?',
                'text',
                NULL,
                17
            ])));

        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(
            [
                'market_description',
                'Opišite svoje tržište, ostvarena partnerstva/reference, kao i strategiju rasta.',
                'text',
                NULL,
                18
            ])));

        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(
            [
                'investment_got',
                'Da li je kompanija dobila investiciju za inovativni proizvod ili tehnologiju?',
                'text',
                NULL,
                19
            ])));

        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(
            [
                'financing_development',
                'Kako kompanija finansira svoj razvoj?',
                'text',
                NULL,
                20
            ])));

        // Rast kompanije na godišnjem nivou
        $ag_annualgrowth = AttributeGroup::get('rastuce_rast_godisnji');
        if($ag_annualgrowth == null) {
            $ag_annualgrowth = AttributeGroup::create(['name' => 'rastuce_rast_godisnji', 'label' => "Rast kompanije na godišnjem nivou", 'sort_order' => 4]);
        }
        $attributeGroups[] = $ag_annualgrowth;

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['stalno_zaposleni_2t', 'Broj stalno zaposlenih t-2', 'integer', NULL, 21])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['stalno_zaposleni_1t', 'Broj stalno zaposlenih t-1', 'integer', NULL, 22])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['stalno_zaposleni_t', 'Broj stalno zaposlenih trenutno', 'integer', NULL, 23])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['stalno_zaposleni_t1', 'Broj stalno zaposlenih t+1', 'integer', NULL, 24])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['stalno_zaposleni_t2', 'Broj stalno zaposlenih t+2', 'integer', NULL, 25])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['angazovani_2t', 'Broj angazovanih t-2', 'integer', NULL, 26])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['angazovani_1t', 'Broj angazovanih t-1', 'integer', NULL, 27])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['angazovani_t', 'Broj angazovanih trenutno', 'integer', NULL, 28])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['angazovani_t1', 'Broj angazovanih t+1', 'integer', NULL, 29])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['angazovani_t2', 'Broj angazovanih t+2', 'integer', NULL, 30])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['praktikanti_2t', 'Broj praktikanata t-2', 'integer', NULL, 31])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['praktikanti_1t', 'Broj praktikanata t-1', 'integer', NULL, 32])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['praktikanti_t', 'Broj praktikanata trenutno', 'integer', NULL, 33])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['praktikanti_t1', 'Broj praktikanata t+1', 'integer', NULL, 34])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['praktikanti_t2', 'Broj praktikanata t+2', 'integer', NULL, 35])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_stalno_zaposleni_2t', 'Broj stalno zaposlenih maticne kompanije t-2', 'integer', NULL, 36])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_stalno_zaposleni_1t', 'Broj stalno zaposlenih maticne kompanije t-1', 'integer', NULL, 37])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_stalno_zaposleni_t', 'Broj stalno zaposlenih maticne kompanije trenutno', 'integer', NULL, 38])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_stalno_zaposleni_t1', 'Broj stalno zaposlenih maticne kompanije t+1', 'integer', NULL, 39])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_stalno_zaposleni_t2', 'Broj stalno zaposlenih maticne kompanije t+2', 'integer', NULL, 40])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_angazovani_2t', 'Broj angazovanih maticne kompanije t-2', 'integer', NULL, 41])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_angazovani_1t', 'Broj angazovanih maticne kompanije t-1', 'integer', NULL, 42])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_angazovani_t', 'Broj angazovanih maticne kompanije trenutno', 'integer', NULL, 43])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_angazovani_t1', 'Broj angazovanih maticne kompanije t+1', 'integer', NULL, 44])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_angazovani_t2', 'Broj angazovanih maticne kompanije t+2', 'integer', NULL, 45])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_praktikanti_2t', 'Broj praktikanata maticne kompanije t-2', 'integer', NULL, 46])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_praktikanti_1t', 'Broj praktikanata maticne kompanije t-1', 'integer', NULL, 47])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_praktikanti_t', 'Broj praktikanata maticne kompanije trenutno', 'integer', NULL, 48])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_praktikanti_t1', 'Broj praktikanata maticne kompanije t+1', 'integer', NULL, 49])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['maticna_praktikanti_t2', 'Broj praktikanata maticne kompanije t+2', 'integer', NULL, 50])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_2t', 'Ukupno prihodi (u EUR) t-2', 'integer', NULL, 51])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_1t', 'Ukupno prihodi (u EUR) t-1', 'integer', NULL, 52])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_t', 'Ukupno prihodi (u EUR) trenutno', 'integer', NULL, 53])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_t1', 'Ukupno prihodi (u EUR) t+1', 'integer', NULL, 54])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_t2', 'Ukupno prihodi (u EUR) t+2', 'integer', NULL, 55])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_commercialization_2t', 'Ukupni prihodi od komercijalizacije inovativnog proizvoda (u EUR) t-2', 'integer', NULL, 56])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_commercialization_1t', 'Ukupni prihodi od komercijalizacije inovativnog proizvoda (u EUR) t-1', 'integer', NULL, 57])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_commercialization_t', 'Ukupni prihodi od komercijalizacije inovativnog proizvoda (u EUR) trenutno', 'integer', NULL, 58])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_commercialization_t1', 'Ukupni prihodi od komercijalizacije inovativnog proizvoda (u EUR) t+1', 'integer', NULL, 59])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_commercialization_t2', 'Ukupni prihodi od komercijalizacije inovativnog proizvoda (u EUR) t+2', 'integer', NULL, 60])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_import_2t', 'Ukupni izvoz (u EUR) t-2', 'integer', NULL, 61])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_import_1t', 'Ukupni izvoz (u EUR) t-1', 'integer', NULL, 62])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_import_t', 'Ukupni izvoz (u EUR) trenutno', 'integer', NULL, 63])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_import_t1', 'Ukupni izvoz (u EUR) t+1', 'integer', NULL, 64])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_import_t2', 'Ukupni izvoz (u EUR) t+2', 'integer', NULL, 65])));

        // Saradnja sa NIO
        $ag_saradnjanio = AttributeGroup::get('rastuce_saradnja_nio');
        if($ag_saradnjanio == null) {
            $ag_saradnjanio = AttributeGroup::create(['name' => 'rastuce_saradnja_nio', 'label' => "Saradnja sa NIO", 'sort_order' => 5]);
        }
        $attributeGroups[] = $ag_saradnjanio;

        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['nio_project', 'Da li imate zajednički projekat sa naučno istraživačkim ', 'text', NULL, 66])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['ino_vaucer', 'Da li ste dobili inovacioni vaučer ili na drugi način angažovali eksperte iz NIO? ', 'text', NULL, 67])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['nio_labs', 'Da li ste koristili laboratorija u okviru NIO? ', 'text', NULL, 68])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['nio_event', 'Da li ste organizovali zajednički događaj NIO? ', 'text', NULL, 69])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['nio_other', 'Drugo (navedite)? ', 'text', NULL, 70])));

        // Potrebe za uslugama u NTP Beograd
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['meeting_rooms', 'Sale za sastanke', 'bool', NULL, 71])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['3d_lab', '3D laboratorija i radionica', 'bool', NULL, 72])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['business_advise_info', 'Poslovno savetovanje i informisanje', 'bool', NULL, 73])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['young_talents', 'Pristup mladim talentima i baza znanja', 'bool', NULL, 74])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['internationalization', 'Umrežavanje i internacionalizacija', 'bool', NULL, 75])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['promotion', 'Promocija i vidljivost', 'bool', NULL, 76])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['nio_contact', 'Kontakt sa NIO', 'bool', NULL, 77])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['financing_sources', 'Pristup izvorima finansiranja i investiciono savetovanje', 'bool', NULL, 78])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['financial_advise', 'Pravno i finansijsko savetovanje', 'bool', NULL, 79])));
        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['resources_other', 'Drugo', 'bool', NULL, 80])));


        // Signature
        $ag_signature = AttributeGroup::get('rastuce_potpis');
        if($ag_signature == null) {
            $ag_signature = AttributeGroup::create(['name' => 'rastuce_potpis', 'label' => "Podaci u potpisu", 'sort_order' => 6]);
        }
        $attributeGroups[] = $ag_signature;

        $attributes->add($ag_signature->addAttribute(self::selectOrCreateAttribute(['ovlasceno_lice', "Ime i prezime ovlašćenog zastupnika", 'varchar', NULL, 81])));
        $attributes->add($ag_signature->addAttribute(self::selectOrCreateAttribute(['funkcija', "Funkcija", 'varchar', NULL, 82])));
        $attributes->add($ag_signature->addAttribute(self::selectOrCreateAttribute(['contact_info', "Kontakt informacije", 'varchar', NULL, 83])));

        return collect(
            [
                'attributes' => $attributes,
                'attributeGroups' => $attributeGroups
            ]);
    }


}
