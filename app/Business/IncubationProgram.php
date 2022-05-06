<?php

namespace App\Business;

use App\AttributeGroup;
use \Illuminate\Support\Collection;

class IncubationProgram extends Program
{
    public function getAttributeGroups()
    {
        $groups = collect([]);

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

        return $groups;
    }

    public function initWorkflow()
    {
        if($this->getWorkflow() == null)
            $this->setWorkflow(new IncubationWorkflow());
        $this->workflow->setCurrentIndex($this->getStatus()-1);
    }

    protected function updateProgramData()
    {
        $this->setData([
            'program_type' => Program::$INKUBACIJA_BITF,
            'program_name' => 'Incubation BITF',
            'program_status' => 1,
        ]);
    }

    protected function setAttributes($data = null)
    {
        // set default values.
        if($data == null) {
            $data = [
                'program_type' => Program::$INKUBACIJA_BITF,
                'program_name' => __('Incubation BITF'),
                'program_status' => 1
            ];
        }

        $this->setData($data);
    }

    /**
     * Returns the textual representation of the program status.
     * @param $status
     * @return string
     */
    protected function getTextForStatus($status): string
    {
        switch ($status) {
            case 1:
                return "Prijava";
            case 2:
                return "Predselekcija";
            case 3:
                return "Selekcija";
            case 4:
                return "Ugovor";
            default:
                return parent::getTextForStatus($status);
        }
    }

    public static function getAttributesDefinition() : Collection
    {
        $attributeData = parent::getAttributesDefinition();

        $attributes = $attributeData['attributes'];
        $attributeGroups = $attributeData['attributeGroups'];

        // Opsti podaci.

        $ag_general = AttributeGroup::get('ibitf_general');
        if($ag_general == null) {
            $ag_general = AttributeGroup::create(['name' => 'ibitf_general', 'label' => __('General Data'), 'sort_order' => 1]);
        }

        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['program_name_or_company', __('Program or Company Name'), 'varchar', NULL, 2])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['date_of_establishment', __('Founding Date'), 'datetime', NULL, 3])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['legal_status', __("Legal Status"), 'varchar', NULL, 4])));

        $primary_activity = $ag_general->addAttribute(self::selectOrCreateAttribute(['business_branch', __('Business Branch'), 'select', NULL, 5]));
        if(count($primary_activity->getOptions()) == 0) {
            $primary_activity->addOption(['value' => 1, 'text' => __('gui-select.BB-IOT')]);
            $primary_activity->addOption(['value' => 2, 'text' => __('gui-select.BB-EnEff')]);
            $primary_activity->addOption(['value' => 3, 'text' => __('gui-select.BB-AI')]);
            $primary_activity->addOption(['value' => 4, 'text' => __('gui-select.BB-NewMat')]);
            $primary_activity->addOption(['value' => 5, 'text' => __('gui-select.BB-TechSport')]);
            $primary_activity->addOption(['value' => 6, 'text' => __('gui-select.BB-vEcoTrans')]);
            $primary_activity->addOption(['value' => 7, 'text' => __('gui-select.BB-RoboAuto')]);
            $primary_activity->addOption(['value' => 8, 'text' => __('gui-select.BB-Tourism')]);
            $primary_activity->addOption(['value' => 9, 'text' => __('gui-select.BB-Education')]);
            $primary_activity->addOption(['value' => 10,'text' => __('gui-select.BB-MediaGaming')]);
            $primary_activity->addOption(['value' => 11, 'text' => __('gui-select.BB-MedTech')]);
            $primary_activity->addOption(['value' => 12, 'text' => __('gui-select.BB-Other')]);
        }
        $attributes->add($primary_activity);

        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['pib', __('Tax ID'), 'varchar', NULL, 6])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['id_number', __('ID Number'), 'varchar', NULL, 7])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['address', __('Address'), 'varchar', NULL, 8])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['number_of_participants', __('Number of Participants'), 'integer', NULL, 9])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['telephone_number', __('Phone Number'), 'varchar', NULL, 10])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['email', __('Email'), 'varchar', ['ui' => 'email'], 11])));
        $attributes->add($ag_general->addAttribute(self::selectOrCreateAttribute(['web', __('Web address'), 'varchar', NULL, 12])));

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
                'label' => __('gui.AG-IBITF-FINANCIALUSERS'),
                'sort_order' => 3
            ]);
        }


        $attributes->add($ag_financial_users->addAttribute(self::selectOrCreateAttribute(['institution_name', __("Institution Name"), 'varchar', NULL, 15])));
        $attributes->add($ag_financial_users->addAttribute(self::selectOrCreateAttribute(['purpose', __('Purpose'), 'varchar', NULL, 16])));
        $attributes->add($ag_financial_users->addAttribute(self::selectOrCreateAttribute(['amount_din', __('Amount RSD'), 'double', NULL, 17 ])));

        $attributeGroups->add($ag_financial_users);

        // Odgovorne osobe.

        $ag_responsible_person = AttributeGroup::get('ibitf_responsible_person');
        if($ag_responsible_person == null) {
            $ag_responsible_person = AttributeGroup::create([
                'name' => 'ibitf_responsible_person',
                'label' => __("Responsible Person"),
                'sort_order' => 4
            ]);
        }

        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_lastname', __('Last Name'), 'varchar', NULL, 18])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_firstname', __('First Name'), 'varchar', NULL, 19])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_telephone', __('Phone'), 'varchar', NULL, 20])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_cellular', __('Cellular'), 'varchar', NULL, 21])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_email', __('Email'), 'varchar', ['ui' => 'email'], 22])));
        $attributes->add($ag_responsible_person->addAttribute(self::selectOrCreateAttribute(['responsible_function', __('Position'), 'varchar', NULL, 23])));

        $attributeGroups->add($ag_responsible_person);

        // Osnivači.

        $ag_founders = AttributeGroup::get('ibitf_founders');
        if($ag_founders == null) {
            $ag_founders = AttributeGroup::create([
                'name' => 'ibitf_founders',
                'label' => __('gui.AG-IBITF-FOUNDERS'),
                'sort_order' => 5
            ]);
        }

        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_name_1', __('First Name and Last Name'), 'varchar', NULL, 24])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_university_1', __('University'), 'varchar', NULL, 25])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_share_1', __('Share [%]'), 'double', NULL, 26])));

        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_name_2', __('First Name and Last Name'), 'varchar', NULL, 27])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_university_2', __('University'), 'varchar', NULL, 28])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_share_2', __('Share [%]'), 'double', NULL, 29])));

        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_name_3', __('First Name and Last Name'), 'varchar', NULL, 30])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_university_3', __('University'), 'varchar', NULL, 31])));
        $attributes->add($ag_founders->addAttribute(self::selectOrCreateAttribute(['founder_share_3', __('Share [%]'), 'double', NULL, 32])));

        $attributeGroups->add($ag_founders);

        // About founding of enterprise.

        $ag_founding_enterprise = AttributeGroup::get('ibitf_founding_enterprise');
        if($ag_founding_enterprise == null) {
            $ag_founding_enterprise = AttributeGroup::create([
                'name' => 'ibitf_founding_enterprise',
                'label' => __('gui.AG-IBITF-FOUNDING-ENTERPRISE'),
                'sort_order' => 6
            ]);
        }

        $attributes->add($ag_founding_enterprise->addAttribute(self::selectOrCreateAttribute(['founding_company_planned', __('gui.founding_company_planned'), 'bool', NULL, 33])));
        $attributes->add($ag_founding_enterprise->addAttribute(self::selectOrCreateAttribute(['founding_act_prepared', __('gui.founding_act_prepared'), 'bool', NULL, 34])));
        $attributes->add($ag_founding_enterprise->addAttribute(self::selectOrCreateAttribute(['founding_act_in_preparation', __('gui.founding_act_in_preparation'), 'bool', NULL, 35])));

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

        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['program_project_name', __('Program/Project Name'), 'text', NULL, 36])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['program_project_description', __('Short Description of Project'), 'text', NULL, 37])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['problem_solving', __('Problem You are Solving'), 'text', NULL, 38])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['solutions', __('Solutions'), 'text', NULL, 39])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['development_phase', __('Development Phase'), 'text', NULL, 40])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['team', __('Team and Work Organization'), 'text', NULL, 41])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['target_groups', __('Target Groups'), 'text', NULL, 42])));
        $attributes->add($ag_general_2->addAttribute(self::selectOrCreateAttribute(['market', __('Market'), 'text', NULL, 43])));

        $attributeGroups->add($ag_general_2);

        // Troškovi

        $ag_expenses = AttributeGroup::get('ibitf_expenses');
        if($ag_expenses == null) {
            $ag_expenses = AttributeGroup::create([
                'name' => 'ibitf_expenses',
                'label' => __('Expenses'),
                'sort_order' => 8
            ]);
        }

        //// Trokovi - godina 1

        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_1_g1', __('Employee Earning').' 1', 'double', NULL, 44])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_2_g1', __('Employee Earning').' 2', 'double', NULL, 45])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_1_g1', __('Compensation of Engaged').' 1', 'double', NULL, 46])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_2_g1', __('Compensation of Engaged').' 2', 'double', NULL, 47])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_g1', __('Bookkeeping'), 'double', NULL, 48])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['Advokati_g1', __('Lawyers'), 'double', NULl, 49])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_g1', __('Office Lease'), 'double', NULL, 50])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_g1', __('Overheads'), 'double', NULL, 51])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_fiksni_troskovi_g1', __("Other Fixed Expenses"), 'double', NULL, 52])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_g1', __('Material Expenses'), 'double', NULL, 53])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_za_rad_g1', __('Working tool expenses'), 'double', NULL, 54])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_troskovi_g1', __("Other expenses"), 'double', NULL, 55])));

        //// Trokovi - godina 2

        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_1_g2', __('Employee Earning').' 1', 'double', NULL, 56])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_2_g2', __('Employee Earning').' 2', 'double', NULL, 57])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_1_g2', __('Compensation of Engaged').' 1', 'double', NULL, 58])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_2_g2', __('Compensation of Engaged').' 2', 'double', NULL, 59])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_g2', __('Bookkeeping'), 'double', NULL, 60])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['Advokati_g2', __('Lawyers'), 'double', NULl, 61])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_g2', __('Office Lease'), 'double', NULL, 62])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_g2', __('Overheads'), 'double', NULL, 63])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_fiksni_troskovi_g2', __("Other Fixed Expenses"), 'double', NULL, 64])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_g2', __('Material Expenses'), 'double', NULL, 65])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_za_rad_g2', __('Working tool expenses'), 'double', NULL, 66])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_troskovi_g2', __("Other expenses"), 'double', NULL, 67])));

        //// Trokovi - godina 3

        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_1_g3', __('Employee Earning').' 1', 'double', NULL, 68])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zarada_zaposleni_2_g3', __('Employee Earning').' 2', 'double', NULL, 69])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_1_g3', __('Compensation of Engaged').' 1', 'double', NULL, 70])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['naknada_agazovani_2_g3', __('Compensation of Engaged').' 2', 'double', NULL, 71])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['knjigovodstvo_g3', __('Bookkeeping'), 'double', NULL, 72])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['Advokati_g3', __('Lawyers'), 'double', NULl, 73])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['zakup_kancelarije_g3', __('Office Lease'), 'double', NULL, 74])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['rezijski_troskovi_g3', __('Overheads'), 'double', NULL, 75])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_fiksni_troskovi_g3', __("Other Fixed Expenses"), 'double', NULL, 76])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_materijala_g3', __('Material Expenses'), 'double', NULL, 77])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['troskovi_alata_za_rad_g3', __('Working tool expenses'), 'double', NULL, 78])));
        $attributes->add($ag_expenses->addAttribute(self::selectOrCreateAttribute(['ostali_troskovi_g3', __("Other expenses"), 'double', NULL, 79])));

        $attributeGroups->add($ag_expenses);

        // Prihodi
        $ag_generate_income = AttributeGroup::get('ibitf_generate_income');
        if($ag_generate_income == null) {
            $ag_generate_income = AttributeGroup::create([
                'name' => 'ibitf_generate_income',
                'label' => __('Generating incomes'),
                'sort_order' => 9
            ]);
        }

        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['generating_income', __('Generating Incomes'), 'text', NULL, 80])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['available_assets', __('Available Assets'), 'double', NULL, 81])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['needed_assets', __('Needed Assets'), 'double', NULL, 82])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['own_assets', __('Own Assets'), 'double', NULL, 83])));
        $attributes->add($ag_generate_income->addAttribute(self::selectOrCreateAttribute(['credits', __("Credits/Other Way of Financing"), 'double', NULL, 84])));

        $attributeGroups->add($ag_generate_income);

        // Infrastrukturne usluge.

        $ag_infrastructure = AttributeGroup::get('ibitf_infrastructure');
        if($ag_infrastructure == null) {
            $ag_infrastructure = AttributeGroup::create([
                'name' => 'ibitf_infrastructure',
                'label' => __('gui.AG-IBITF-INFRASTRUCTURE'),
                'sort_order' => 10
            ]);
        }

        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['office_space', __('gui.office_space'), 'double', NULL, 85])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['administrative_services', __('gui.administrative_services'), 'bool', NULL, 86])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['bookkeeping_services', __('gui.bookkeeping_services'), 'bool', NULL, 87])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['legal_services', __('gui.legal_services'), 'bool', NULL, 88])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['other_services', __('gui.other_services'), 'varchar', NULL, 89])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['consulting_services', __('gui.consulting_services'), 'bool', NULL, 90])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['specific_needs', __('gui.specific_needs'), 'varchar', NULL, 91])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['promotion_services', __('gui.promotion_services'), 'bool', NULL, 92])));
        $attributes->add($ag_infrastructure->addAttribute(self::selectOrCreateAttribute(['connection_services', __('gui.connection_services'), 'bool', NULL, 93])));

        $attributeGroups->add($ag_infrastructure);

        $ag_attachments = AttributeGroup::get('ibitf_attachments');
        if($ag_attachments == null) {
            $ag_attachments = AttributeGroup::create([
                'name' => 'ibitf_attachments',
                'label' => __("Attachments"),
                'sort_order' => 11
            ]);
        }

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute(
            [
                'resenje_apr_link',
                __('gui.resenje_apr_link'),
                'varchar',
                NULL,
                94
            ])));

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute([
            'resenje_fajl',
            __('gui.resenje_fajl'),
            'file',
            NULL,
            95
        ])));

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute([
            'linkedin_founders',
            __('gui.linkedin_founders'),
            'text',
            NULL,
            96
        ])));

        $attributes->add($ag_attachments->addAttribute(self::selectOrCreateAttribute([
            'founders_cv',
            __('gui.founders_cv'),
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
}
