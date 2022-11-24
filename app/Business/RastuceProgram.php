<?php

namespace App\Business;

use App\AttributeGroup;
use Illuminate\Support\Collection;

class RastuceProgram extends Program
{
    public function getAttributeGroups() {
        $groups = collect([]);

        $groups->add(AttributeGroup::get('rastuce_header'));
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
            'program_name' => __('Growing Companies'),
            'program_status' => 1,
        ]);
    }

    protected function setAttributes($data = null)
    {
        // set default values.
        if($data == null) {
            $data = [
                'program_type' => Program::$RASTUCE_KOMPANIJE,
                'program_name' => __('Growing Companies'),
                'program_status' => 1
            ];
        }

        $this->setData($data);
    }

    protected function getTextForStatus($status): string
    {
        switch($status) {
            case 1:
                return __('Prijava');
            case 2:
                return __('Validacija');
            case 3:
                return __('Ugovor');
            default:
                return parent::getTextForStatus($status);
        }
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributeData = parent::getAttributesDefinition();

        $attributes = $attributeData['attributes'];
        $attributeGroups = $attributeData['attributeGroups'];

        // Zaglavlje
        $ag_header = self::getAttributeGroup('rastuce_header', __('Zaglavlje'), 0);
        $attributeGroups->add($ag_header);

        $intentions = self::selectOrCreateAttribute(['intention', __('Kompanija namerava da:'), 'select', NULL, 1]);
        if(count($intentions->getOptions()) == 0) {
            $intentions->addOption(['value' => 1, 'text' => __('gui-select.company_intentions_partially_move')]);
            $intentions->addOption(['value' => 2, 'text' => __('gui-select.company_intentions_move')]);
            $intentions->addOption(['value' => 3, 'text' => __('gui-select.company_intentions_independent')]);
        }

        $attributes->add($ag_header->addAttribute($intentions));

        $company_type = self::selectOrCreateAttribute(['company_type', __('Strana kompanija koja'), 'select', NULL, 2 ]);
        if(count($company_type->getOptions()) == 0) {
            $company_type->addOption(['value' => 1, 'text' => __('gui-select.company_type_founded')]);
            $company_type->addOption(['value' => 2, 'text' => __('gui-select.company_type_planned')]);
        }

        $attributes->add($ag_header->addAttribute($company_type));

        $membership_type = self::selectOrCreateAttribute(['apply_for_membership_type', __('Konkurišete za'), 'select', NULL, 3]);
        if(count($membership_type->getOptions()) == 0) {
            $membership_type->addOption(['value' => 1, 'text' => __('gui-select.membership_type_full')]);
            $membership_type->addOption(['value' => 2, 'text' => __('gui-select.membership_type_virtual')]);
        }

        $attributes->add($ag_header->addAttribute($membership_type));


        // Opsti podaci
        $ag_general = self::getAttributeGroup('rastuce_general', 'Opšti podaci', 1);
        $attributeGroups->add($ag_general);

        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['company_name', "Naziv kompanije", 'varchar', NULL, 1])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['id_number', "Matični broj", 'varchar', NULL, 2])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['founding_date', "Datum osnivanja", 'datetime', NULL, 3])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['webpage', "Internet stranica", 'varchar', NULL, 4])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['business_branch', "Sektor/Oblast/Industrija", 'select', NULL, 5])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['responsible_person', "Odgovorno lice", 'varchar', NULL, 6])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['contact', "Kontakt", 'varchar', NULL, 7])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['innovative_product', "Inovativni proizvod ili tehnologija", 'varchar', NULL, 8])));

        // Tim
        $ag_tim = self::getAttributeGroup('rastuce_tim', __('Tim'), 2);
        $attributeGroups->add($ag_tim);

        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['team_description', 'Da li je tim uspostavljen i razvijen?', 'text', NULL, 9])));

        // Razvoj inovativnog proizvoda ili tehnologije
        $ag_innovative = self::getAttributeGroup('rastuce_inovative', __('Razvoj inovativnog proizvoda ili tehnologije'), 3);
        $attributeGroups->add($ag_innovative);

        // Proizvod 1
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['innovative_product_1', "Proizvod 1", 'varchar', NULL, 10])));
        $innovative_phase1 = self::selectOrCreateAttribute(['innovative_phase_1', 'Faza razvoja inovacije/tehnologije 1', 'select', 'multiselect', 10]);
        if(count($innovative_phase1->getOptions()) == 0) {
            $innovative_phase1->addOption(["value" => 1, 'text' => 'Ideja ili nacrt']);
            $innovative_phase1->addOption(["value" => 2, 'text' => 'Prototip u laboratoriji ili eksperimentalnom okruženju']);
            $innovative_phase1->addOption(["value" => 3, 'text' => 'Testiran prototip']);
            $innovative_phase1->addOption(["value" => 4, 'text' => 'Minimalno održivi proizvod - MVP']);
            $innovative_phase1->addOption(["value" => 5, 'text' => 'Ideja ili nacrt']);
        }

        $attributes->add($ag_innovative->addAttribute($innovative_phase1));

        // Proizvod 2
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['innovative_product_2', "Proizvod 2", 'varchar', NULL, 10])));
        $innovative_phase2 = self::selectOrCreateAttribute(['innovative_phase_2', 'Faza razvoja inovacije/tehnologije 2', 'select', 'multiselect', 10]);
        if(count($innovative_phase2->getOptions()) == 0) {
            $innovative_phase2->addOption(["value" => 1, 'text' => 'Ideja ili nacrt']);
            $innovative_phase2->addOption(["value" => 2, 'text' => 'Prototip u laboratoriji ili eksperimentalnom okruženju']);
            $innovative_phase2->addOption(["value" => 3, 'text' => 'Testiran prototip']);
            $innovative_phase2->addOption(["value" => 4, 'text' => 'Minimalno održivi proizvod - MVP']);
            $innovative_phase2->addOption(["value" => 5, 'text' => 'Ideja ili nacrt']);
        }

        $attributes->add($ag_innovative->addAttribute($innovative_phase2));

        // Proizvod 3
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['innovative_product_3', "Proizvod 3", 'varchar', NULL, 10])));
        $innovative_phase3 = self::selectOrCreateAttribute(['innovative_phase_3', 'Faza razvoja inovacije/tehnologije 3', 'select', 'multiselect', 10]);
        if(count($innovative_phase3->getOptions()) == 0) {
            $innovative_phase3->addOption(["value" => 1, 'text' => 'Ideja ili nacrt']);
            $innovative_phase3->addOption(["value" => 2, 'text' => 'Prototip u laboratoriji ili eksperimentalnom okruženju']);
            $innovative_phase3->addOption(["value" => 3, 'text' => 'Testiran prototip']);
            $innovative_phase3->addOption(["value" => 4, 'text' => 'Minimalno održivi proizvod - MVP']);
            $innovative_phase3->addOption(["value" => 5, 'text' => 'Ideja ili nacrt']);
        }

        $attributes->add($ag_innovative->addAttribute($innovative_phase3));

        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['product_developed', 'Da li su inovativni proizvod ili tehnologija razvijeni?', 'text', NULL, 11])));
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['innovation_grade', 'Opišite stepen inovativnosti tehnologije', 'text', NULL, 12])));
        $attributes->add($ag_innovative->addAttribute(self::selectOrCreateAttribute(['intellectual_property_protected', 'Da li kompanija ima zaštićena prava intelektualne svojine?', 'text', NULL, 13])));

        // Razvoj tržišta i komercijalizacija
        $ag_marketdev = self::getAttributeGroup('rastuce_razvoj_trzista', __('Razvoj tržišta i komercijalizacija'), 4);
        $attributeGroups->add($ag_marketdev);

        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(['product_commercialization_1', __('Proizvod 1'), 'varchar', NULL, 14])));
        $commercialization_phase_1 = self::selectOrCreateAttribute(['commercialization_phase_1', __('Faza komercijalizacije - proizvod 1'), 'select', NULL, 15]);
        if(count($commercialization_phase_1->getOptions()) == 0) {
            $commercialization_phase_1->addOption(['value' => 1, 'text' => __('gui-select.commercialization_phase_first_contacts') ]);
            $commercialization_phase_1->addOption(['value' => 2, 'text' => __('gui-select.commercialization_phase_need_confirmed') ]);
            $commercialization_phase_1->addOption(['value' => 3, 'text' => __('gui-select.commercialization_phase_product_established') ]);
            $commercialization_phase_1->addOption(['value' => 4, 'text' => __('gui-select.commercialization_phase_growth_strategy') ]);
        }
        $attributes->add($ag_marketdev->addAttribute($commercialization_phase_1));

        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(['product_commercialization_2', __('Proizvod 2'), 'varchar', NULL, 16])));
        $commercialization_phase_2 = self::selectOrCreateAttribute(['commercialization_phase_2', __('Faza komercijalizacije - proizvod 2'), 'select', NULL, 17]);
        if(count($commercialization_phase_2->getOptions()) == 0) {
            $commercialization_phase_2->addOption(['value' => 1, 'text' => __('gui-select.commercialization_phase_first_contacts') ]);
            $commercialization_phase_2->addOption(['value' => 2, 'text' => __('gui-select.commercialization_phase_need_confirmed') ]);
            $commercialization_phase_2->addOption(['value' => 3, 'text' => __('gui-select.commercialization_phase_product_established') ]);
            $commercialization_phase_2->addOption(['value' => 4, 'text' => __('gui-select.commercialization_phase_growth_strategy') ]);
        }
        $attributes->add($ag_marketdev->addAttribute($commercialization_phase_2));

        $attributes->add($ag_marketdev->addAttribute(self::selectOrCreateAttribute(['product_commercialization_3', __('Proizvod 3'), 'varchar', NULL, 18])));
        $commercialization_phase_3 = self::selectOrCreateAttribute(['commercialization_phase_3', __('Faza komercijalizacije - proizvod 3'), 'select', NULL, 19]);
        if(count($commercialization_phase_3->getOptions()) == 0) {
            $commercialization_phase_3->addOption(['value' => 1, 'text' => __('gui-select.commercialization_phase_first_contacts') ]);
            $commercialization_phase_3->addOption(['value' => 2, 'text' => __('gui-select.commercialization_phase_need_confirmed') ]);
            $commercialization_phase_3->addOption(['value' => 3, 'text' => __('gui-select.commercialization_phase_product_established') ]);
            $commercialization_phase_3->addOption(['value' => 4, 'text' => __('gui-select.commercialization_phase_growth_strategy') ]);
        }
        $attributes->add($ag_marketdev->addAttribute($commercialization_phase_3));

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
        $ag_annualgrowth = self::getAttributeGroup('rastuce_rast_godisnji', __('Rast kompanije na godišnjem nivou'), 5);
        $attributeGroups->add($ag_annualgrowth);

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

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_2t', 'Ukupni izvoz (u EUR) t-2', 'integer', NULL, 61])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_1t', 'Ukupni izvoz (u EUR) t-1', 'integer', NULL, 62])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_t', 'Ukupni izvoz (u EUR) trenutno', 'integer', NULL, 63])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_t1', 'Ukupni izvoz (u EUR) t+1', 'integer', NULL, 64])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_t2', 'Ukupni izvoz (u EUR) t+2', 'integer', NULL, 65])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_maticna_2t', 'Ukupno prihodi (u EUR) t-2', 'integer', NULL, 51])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_maticna_1t', 'Ukupno prihodi (u EUR) t-1', 'integer', NULL, 52])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_maticna_t', 'Ukupno prihodi (u EUR) trenutno', 'integer', NULL, 53])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_maticna_t1', 'Ukupno prihodi (u EUR) t+1', 'integer', NULL, 54])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_income_maticna_t2', 'Ukupno prihodi (u EUR) t+2', 'integer', NULL, 55])));

        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_maticna_2t', 'Ukupni izvoz (u EUR) t-2', 'integer', NULL, 61])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_maticna_1t', 'Ukupni izvoz (u EUR) t-1', 'integer', NULL, 62])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_maticna_t', 'Ukupni izvoz (u EUR) trenutno', 'integer', NULL, 63])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_maticna_t1', 'Ukupni izvoz (u EUR) t+1', 'integer', NULL, 64])));
        $attributes->add($ag_annualgrowth->addAttribute(self::selectOrCreateAttribute(['total_export_maticna_t2', 'Ukupni izvoz (u EUR) t+2', 'integer', NULL, 65])));

        // Saradnja sa NIO
        $ag_saradnjanio = AttributeGroup::get('rastuce_saradnja_nio');
        if($ag_saradnjanio == null) {
            $ag_saradnjanio = AttributeGroup::create(['name' => 'rastuce_saradnja_nio', 'label' => "Saradnja sa NIO", 'sort_order' => 5]);
        }
        $ag_saradnjanio = self::getAttributeGroup('rastuce_saradnja_nio', __('Saradnja sa NIO'), 6);
        $attributeGroups->add($ag_saradnjanio);

        $attributes->add($ag_saradnjanio->addAttribute(self::selectOrCreateAttribute(['nio_project', 'Da li imate zajednički projekat sa naučno-istraživačkim organizacijama?', 'text', NULL, 66])));
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
        $ag_signature = self::getAttributeGroup('rastuce_potpis', __('Podaci u potpisu'), 7);
        $attributeGroups->add($ag_signature);

        $attributes->add($ag_signature->addAttribute(self::selectOrCreateAttribute(['ovlasceno_lice', "Ime i prezime ovlašćenog zastupnika", 'varchar', NULL, 81])));
        $attributes->add($ag_signature->addAttribute(self::selectOrCreateAttribute(['funkcija', "Funkcija", 'varchar', NULL, 82])));
        $attributes->add($ag_signature->addAttribute(self::selectOrCreateAttribute(['contact_info', "Kontakt informacije", 'varchar', NULL, 83])));

        // Attachments
        $ag_attachments = self::getAttributeGroup('rastuce_attachments', __('Prilozi za rastuce'), 8);
        $attributeGroups->add($ag_attachments);

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute(['rastuce_financial_reports', 'Redovni godišnji finansijski izveštaji', 'file', 'multiple', 84])));
        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute(['rastuce_cvs', 'Biografije', 'file', 'multiple', 85])));
        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute(['rastuce_presentation', 'Prezentacija (PPT ili druga forma)', 'file', 'multiple', 86])));

        return collect(
            [
                'attributes' => $attributes,
                'attributeGroups' => $attributeGroups
            ]);
    }


}
