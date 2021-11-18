<?php

namespace App\Business;

use App\AttributeGroup;
use Illuminate\Support\Collection;

class RaisingStartsProgram extends Program
{
    public function getAttributeGroups()
    {
        $groups = collect([]);

        $groups->add(AttributeGroup::get('rstarts_general'));
        $groups->add(AttributeGroup::get('rstarts_applicant'));
        $groups->add(AttributeGroup::get('rstarts_tim'));
        $groups->add(AttributeGroup::get('rstarts_ideja'));
        $groups->add(AttributeGroup::get('startup_story'));
        $groups->add(AttributeGroup::get('dodatna_dokumentacija'));

        return $groups;
    }

    protected function initWorkflow($instanceId = null)
    {
        if($this->getWorkflow() == null)
            $this->setWorkflow(new RaisingStartsWorkflow());
    }

    protected function updateProgramData()
    {
        $this->setData([
            'program_type' => Program::$RAISING_STARTS,
            'program_name' => 'Raising Starts',
            'program_status' => 1
        ]);
    }

    protected function setAttributes($data = null)
    {
        // Set default values.
        if($data == null) {
            $data = [
                'program_type' => Program::$RAISING_STARTS,
                'program_name' => 'Raising Starts',
                'program_status' => 1
            ];
        }

        $this->setData($data);
    }

    public static function getAttributesDefinition() : Collection
    {
        $attributeData = parent::getAttributesDefinition();

        $attributes = $attributeData['attributes'];
        $attributeGroups = $attributeData['attributeGroups'];

        // -------------------------------------- OSNOVNI PODACI ----------------------------------------- //
        $ag_general = self::getAttributeGroup('rstarts_general',__('General Data'), 1);
        $attributeGroups->add($ag_general);

        $apptype = self::selectOrCreateAttribute(['app_type', 'Prijavljuje se kao', 'select', NULL, 1]);
        if(count($apptype->getOptions()) == 0) {
            $apptype->addOption(['value' => 1, 'text' => 'Startap tim (minimum 2 člana tima)']);
            $apptype->addOption(['value' => 2, 'text' => 'Registrovano privredno društvo ne starije od 2 godine u većinski srpskom vlasništvu']);
        }

        $attributes->add($ag_general->addAttribute($apptype));

        // -------------------------------------- PODNOSILAC PRIJAVE --------------------------------------- //
        $ag_applicant = self::getAttributeGroup('rstarts_applicant', __('Applicant'), 2);
        $attributeGroups->add($ag_applicant);

        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_startup_name', __('Startup Name'), 'varchar', NULL, 3])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_applicant_name', __('Applicant Name'), 'varchar', NULL, 4])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_position', __('Position'), 'varchar', NULL, 5])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_address', __('Address'), 'varchar', NULL, 6])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_email', __('Email'), 'varchar', ['ui' => 'email'], 7])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_telephone', __('Phone'), 'varchar', NULL, 8])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_logo', __('Logo'), 'file', NULL, 9])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_webpage', __('Webpage'), 'varchar', NULL, 10])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_founding_date', __('Founding Date'), 'datetime', NULL, 11])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_id_number', __('ID Number'), 'varchar', NULL, 12])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_basic_registered_activity', __('Basic Registered Activity'), 'varchar', NULL, 13])));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_short_ino_desc', __('Short Innovation Description'), 'text', NULL, 14])));
        $product_type = self::selectOrCreateAttribute(['rstarts_product_type', __('Product Type'), 'select', NULL, 15]);
        if(count($product_type->getOptions()) == 0) {
            $product_type->addOption(['value' => 1, 'text' => __('Software')]);
            $product_type->addOption(['value' => 2, 'text' => __('Hardware/material product')]);
            $product_type->addOption(['value' => 3, 'text' => __('Combined')]);
        }
        $attributes->add($ag_applicant->addAttribute($product_type));
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['jmbg', 'JMBG', 'varchar', NULL, 47])));

        // ------------------------------------------- TIM ------------------------------------------- //
        // (TIM) Biće dodano prilikom kreiranja programa
        // (OSNIVACI - STRUKTURA) Biće dodano prilikom kreiranja programa

        $ag_tim = self::getAttributeGroup('rstarts_tim', __('Team'), 3);
        $attributeGroups->add($ag_tim);
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_founder_cvs', __('Founder CV\'s'), 'file', 'multiple', 16])));
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_founder_links', __('Founder Links'), 'varchar', 'multiple', 17])));
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_team_history', __('Team History'), 'text', NULL, 18])));
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_app_motive', __('Application Motive'), 'text', NULL, 19])));

        // -------------------------------------- POSLOVNA IDEJA ------------------------------------- //
        $ag_ideja = self::getAttributeGroup('rstarts_ideja', __('Idea'), 4);
        $attributeGroups->add($ag_ideja);
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_tagline', __('Navedite slogan vašeg startapa'), 'text', NULL, 19])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_solve_problem', __('Which Problem is Solved'), 'text', NULL, 20])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_targetted_market', __('Targeted Market'), 'text', NULL, 21])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_problem_solve', __('Whose Problem is Being Solved'), 'text', NULL, 22])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_which_product', __('Which Innovative Product is being Developed'), 'text', NULL, 23])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_benefits', __('What Benefits'), 'text', NULL, 24])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_customer_problem_solve', __('How are the Customers solving the Problem?'), 'text', NULL, 25])));
        $howInnovative = self::selectOrCreateAttribute(['rstarts_how_innovative', __('How innovative'), 'select', NULL, 26]);
        if(count($howInnovative->getOptions()) == 0) {
            $howInnovative->addOption(['value' => 1, 'text' =>'Već postojeći proizvod i/ili usluga']);
            $howInnovative->addOption(['value' => 2, 'text' =>'Poznat, ali nedovoljno primenjen proizvod i/ili usluga ']);
            $howInnovative->addOption(['value' => 3, 'text' => 'Poboljšan postojeći proizvod i/ili usluga']);
            $howInnovative->addOption(['value' => 4, 'text' => 'Značajno poboljšan postojeći proizvod i/ili usluga']);
            $howInnovative->addOption(['value' => 5, 'text' => 'Potpuno nov proizvod i/ili usluga']);
        }
        $attributes->add($ag_ideja->addAttribute($howInnovative));

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_clarification_innovative', __('Clarification Innovative'), 'text', NULL, 27])));

        $dev_phase_tech = self::selectOrCreateAttribute(['rstarts_dev_phase_tech', "Tehnološki razvoj", 'select', NULL, 28]);
        if(count($dev_phase_tech->getOptions()) == 0) {
            $dev_phase_tech->addOption(['value' => 1, 'text' => 'Ideja/prepoznat osnovni koncept']);
            $dev_phase_tech->addOption(['value' => 2, 'text' => 'Dokaz koncepta']);
            $dev_phase_tech->addOption(['value' => 3, 'text' => 'Razvijen prvi prototip / razvijena alpha verzija']);
            $dev_phase_tech->addOption(['value' => 4, 'text' => 'Razvijen drugi prototip / razvijena beta verzija']);
            $dev_phase_tech->addOption(['value' => 5, 'text' => 'MVP 1.0']);
            $dev_phase_tech->addOption(['value' => 6, 'text' => 'Stabilna prva verzija proizvoda koja se kontinuirano unapređuje']);
        }
        $attributes->add($ag_ideja->addAttribute($dev_phase_tech));

        $dev_phase_business = self::selectOrCreateAttribute(['rstarts_dev_phase_bussines', "Poslovni razvoj", 'select', NULL, 29]);
        if(count($dev_phase_business->getOptions()) == 0) {
            $dev_phase_business->addOption(['value' => 1, 'text' => 'Hipoteza o mogućim potrebama']);
            $dev_phase_business->addOption(['value' => 2, 'text' => 'Indetifikovane potrebe na tržistu']);
            $dev_phase_business->addOption(['value' => 3, 'text' => 'Uspostavljene prve povratne informacije sa tržista']);
            $dev_phase_business->addOption(['value' => 4, 'text' => 'Potvrđeni problem / potrebe nekoliko kupaca i / ili korisnika']);
            $dev_phase_business->addOption(['value' => 5, 'text' => 'Utvrđeno interesovanje za proizvod i uspostavljeni odnosi sa ciljnom grupom']);
            $dev_phase_business->addOption(['value' => 6, 'text' => 'Prednosti rešenja potvrđene prvim testiranjem kupaca i/ili partnerstvom za pristup tržištu ']);
            $dev_phase_business->addOption(['value' => 7, 'text' => 'Kupci u dužem/kontinuiranom ispitivanju proizvoda i / ili ostvarene prve probne prodaje u periodu ne dužem od 6 meseci']);
            $dev_phase_business->addOption(['value' => 8, 'text' => 'U prethodnih 6 meseci generisan prihod veći od 10 hiljada ili 15 hiljada švajcarskih franaka']);
            $dev_phase_business->addOption(['value' => 9, 'text' => 'Rasprostranjena prodaja proizvoda / širenje tržista']);
        }
        $attributes->add($ag_ideja->addAttribute($dev_phase_business));

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['six_months_income', 'Navedite iznos prihoda u poslednjih 6 meseci', 'double', NULL, 48])));

        $ippactivities = self::selectOrCreateAttribute(['rstarts_intellectual_property', 'Da li ste sprovodili neke aktivnosti u cilju zaštite prava intelektualne svojine?', 'select', NULL, 30]);
        if(count($ippactivities->getOptions()) == 0) {
            $ippactivities->addOption(['value' => 1, 'text' => 'Inicijalno istraživanje (konsultacije sa Zavodom za intelektualnu svojinu RS)']);
            $ippactivities->addOption(['value' => 2, 'text' => 'Dobijen Izveštaj o obavljenom istraživanju od strane Zavoda za zaštitu intelektualne svojine']);
            $ippactivities->addOption(['value' => 3, 'text' => 'Podneta aplikacija za zaštitu nekog prava IP']);
            $ippactivities->addOption(['value' => 4, 'text' => 'Zaštićen žig (logo), autorsko delo i/ili neko srodno pravo']);
            $ippactivities->addOption(['value' => 5, 'text' => 'Zaštićen mali patent, patent']);
            $ippactivities->addOption(['value' => 6, 'text' => 'Zaštićeno pravo industrijskog dizajna']);
            $ippactivities->addOption(['value' => 7, 'text' => 'Nismo']);
        }
        $attributes->add($ag_ideja->addAttribute($ippactivities));

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_research', 'Molimo vas opišite, sa najviše 50 reči,
        da li ste sproveli neko istraživanje na temu intelektualne svojine, mogućnosti zaštite intelektualne svojine ili ukoliko ste zaštitili logotip,
        patent, mali patent ili slično. Ukoliko ste zaštitili ili planirate da zaštitite neko pravo intelektualne svojine, navedite ko su vlasnici
        ili ko bi bili vlasnici te intelektualne svojine', 'text', NULL, 31])));

        $oblast = $ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_innovative_area', 'Kojoj oblasti pripada inovativni proizvod i/ili usluga koju razvijate?', 'select', NULL, 32]));
        if(count($oblast->getOptions()) == 0) {
            $oblast->addOption(['value' => 1, 'text' => __('gui-select.BB-IOT')]);
            $oblast->addOption(['value' => 2, 'text' => __('gui-select.BB-EnEff')]);
            $oblast->addOption(['value' => 3, 'text' => __('gui-select.BB-AI')]);
            $oblast->addOption(['value' => 4, 'text' => __('gui-select.BB-NewMat')]);
            $oblast->addOption(['value' => 5, 'text' => __('gui-select.BB-Civic')]);
            $oblast->addOption(['value' => 6, 'text' => __('gui-select.BB-TechSport')]);
            $oblast->addOption(['value' => 7, 'text' => __('gui-select.BB-Finance')]);
            $oblast->addOption(['value' => 8, 'text' => __('gui-select.BB-Marketing')]);
            $oblast->addOption(['value' => 9, 'text' => __('gui-select.BB-EcoTrans')]);
            $oblast->addOption(['value' => 10, 'text' => __('gui-select.BB-RoboAuto')]);
            $oblast->addOption(['value' => 11, 'text' => __('gui-select.BB-Tourism')]);
            $oblast->addOption(['value' => 12, 'text' => __('gui-select.BB-Education')]);
            $oblast->addOption(['value' => 13,'text' => __('gui-select.BB-MediaGaming')]);
            $oblast->addOption(['value' => 14, 'text' => __('gui-select.BB-MedTech')]);
            $oblast->addOption(['value' => 15, 'text' => __('gui-select.BB-Agriculture')]);
            $oblast->addOption(['value' => 16, 'text' => __('gui-select.BB-Other')]);
        }

        $attributes->add($oblast);

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_innovative_area_other', 'Ukoliko je izbor "Ostalo" navedite oblast', 'varchar', NULL, 47])));

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_business_plan', 'Kako vaš startap planira da zaradjuje?', 'text', NULL, 33])));

        // ------------------------------------------------- VAŠA STARTAP PRIČA ------------------------------------------------ //
        $ag_startup_story = self::getAttributeGroup('startup_story', 'Vaša startup priča', 5);
        $attributeGroups->add($ag_startup_story);

        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_statup_progress', 'Ukratko opišite napredak koji ste postigli do sada', 'text', NULL, 34])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_files', 'Prilozeni fajlovi', 'file', 'multiple', 35])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_links', 'Prilozeni linkovi', 'varchar', 'multiple', 36])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_mentor_program_history', 'Navedite ukoliko ste ranije učestvovali u nekom mentorskom ili startap programu', 'text', NULL, 37])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_financing_sources', 'Da li ste vec dosad prikupili bilo koji izvor finansiranja', 'text', NULL, 38])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_financing_proof_files', 'Dokazni fajlovi', 'file', 'multiple', 39])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_financing_proof_links', 'Dokazni linkovi', 'varchar', 'multiple', 40])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_expectations', 'Šta očekujete od učešća u programu', 'text', NULL, 41])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_howmuchmoney', 'Koliko finansijskih sredstava mislite da vam je potrebno u trenutnoj fazi razvoja i za šta', 'text', NULL, 42])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_linkclip', 'Link video klipa', 'varchar', 'link', 43])));

        $howdiduhear = self::selectOrCreateAttribute(['rstarts_howdiduhear', 'Kako ste culi za nas', 'select', NULL, 44]);
        if(count($howdiduhear->getOptions()) == 0) {
            $howdiduhear->addOption(['value' => 1, 'text' => 'Zvanične društvene mreže programa Raising Starts']);
            $howdiduhear->addOption(['value' => 2, 'text' => 'Zvanične društvene mreže NTP Beograd']);
            $howdiduhear->addOption(['value' => 3, 'text' => 'Zvanične društvene mreže NTP Niš i Čačak']);
            $howdiduhear->addOption(['value' => 4, 'text' => 'E-mail/newsletter NTP Beograd/NTP Niš/NTP Čačak']);
            $howdiduhear->addOption(['value' => 5, 'text' => 'Webstranice NTP Beograd/NTP Niš/NTP Čačak']);
            $howdiduhear->addOption(['value' => 6, 'text' => 'Mediji (TV, web, štampa ...)']);
            $howdiduhear->addOption(['value' => 7, 'text' => 'Saradnik/poznanik mi je preporučio program']);
            $howdiduhear->addOption(['value' => 8, 'text' => 'Ostalo']);
        }

        $attributes->add($ag_startup_story->addAttribute($howdiduhear));

        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_other_sources', "Ukoliko ste obeležili “Ostalo” molimo vas da navedete da li ste čuli putem vesti/društvenih mreža/website-a/e-mail-a/newslettera partnerskih organizacija i navedite ime organizacije, preko poznanika/studentske organizacije i navedite ime ili drugo - opciono dopuniti.", 'text', NULL, 45])));

        $ag_dodatna_dokumentacija = self::getAttributeGroup('dodatna_dokumentacija', 'Dodatna dokumentacija', 7);
        $attributeGroups->add($ag_dodatna_dokumentacija);

        $attributes->add($ag_dodatna_dokumentacija->addAttribute(self::selectOrCreateAttribute(['rstarts_dodatni_dokumenti', 'Dodatni dokumenti', 'file', 'multiple', 46])));

        return collect(
            [
                'attributes' => $attributes,
                'attributeGroups' => $attributeGroups
            ]);

    }
}
