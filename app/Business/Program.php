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

            $this->setData([
                'program_type' => $programType,
                'program_name' => Program::getProgramName($programType),
                'needs_contract' => Program::needsContract($programType),
                'needs_preselection' => Program::needsPreselection($programType)
            ]);

            $this->setAttributes($data);
        }

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

    /**
     * Add preselection to program.
     * @param Preselection $preselection
     * @return Preselection
     */
    public function addPreselection(Preselection $preselection) {
        $this->instance->instances()->save($preselection->instance);
        $this->instance->refresh();
        return $preselection;
    }

    /**
     * Remove preselection from program.
     */
    public function removePreselection() {
        $preselectionEntity = Entity::where('name', 'Preselection')->first();
        $preselectionInstance = $this->instance->instances->where('entity_id', $preselectionEntity->id)->first();
        $this->instance->instances()->detach($preselectionInstance->id);
        $this->instance->refresh();

    }

    /**
     * Returns the program preselection, if exists.
     * @return Preselection|null
     */
    public function getPreselection(): ?Preselection
    {
        $preselectionEntity = Entity::where('name', 'Preselection')->first();
        $preselectionInstance = $this->instance->instances->where('entity_id', $preselectionEntity->id)->first();
        if($preselectionInstance == null) {
            return null;
        }

        return new Preselection(['instance_id' => $preselectionInstance->id]);
    }

    /**
     * Adds selection to the program.
     * @param Selection $selection
     * @return Selection
     */
    public function addSelection(Selection $selection): Selection
    {
        $this->instance->instances()->save($selection->instance);
        $this->instance->refresh();
        return $selection;
    }

    /**
     * Remove selection from the program.
     * @param Selection $selection
     */
    public function removeSelection() {
        $selection = $this->getSelection();
        if($selection == null)
            return true;

        $this->instance->instances()->detach($selection->instance->id);
        $this->instance->refresh();

        $selection->delete();

        return true;
    }

    /**
     * Return current associated program selection object.
     * @return Selection|null
     */
    public function getSelection(): ?Selection
    {
        $selectionEntity = Entity::where('name', 'Selection')->first();
        $selectionInstance = $this->instance->instances->where('entity_id', $selectionEntity->id)->first();
        if($selectionInstance == null) {
            return null;
        }

        return new Selection(['instance_id' => $selectionInstance->id]);
    }

    /**
     * Adds the contract to the program.
     * @param Contract $contract
     * @return Contract
     */
    public function addContract(Contract $contract): Contract
    {
        $this->instance->instances()->save($contract->instance);
        $this->instance->refresh();
        return $contract;
    }

    /**
     * Removes the contract from the program.
     * @return bool
     */
    public function removeContract(): bool
    {
        $contract = $this->getContract();
        if($contract == null)
            return false;

        $this->instance->instances()->detach($contract->instance->id);
        $this->instance->refresh();

        $contract->delete();

        return true;
    }

    /**
     * Fetches the current contract.
     * @return Contract|null
     */
    public function getContract(): ?Contract
    {
        $contractEntity = Entity::where('name', 'Contract')->first();
        $contractInstance = $this->instance->instances->where('entity_id', $contractEntity->id)->first();
        if($contractInstance == null) {
            return null;
        }

        return new Contract(['instance_id' => $contractInstance->id]);
    }

    /**
     * Gets the profile the program belongs to.
     * @return Profile
     */
    public function getProfile(): Profile
    {
        return $this->instance->parentInstances->filter(function($instance) {
            if($instance->entity->name == 'Profile')
                return true;
        })->map(function($instance) {
            return new Profile(['instance_id' => $instance->id]);
        })->first();

    }

    /**
     * Add program attendance.
     * @param $attendance
     * @return mixed
     */
    public function addAttendance($attendance) {
        $this->instance->instances()->save($attendance->instance);
        $this->instance->refresh();
    }

    /**
     * Remove program attendance.
     * @param $attendance
     */
    public function removeAttendance($attendance) {
        $this->instance->instances()->detach($attendance->id);
        $this->instance->refresh();
    }

    /**
     * Get the attendances to programs.
     * @return mixed
     */
    public function getAttendances() {
        return $this->instance->instances->filter(function($instance) {
            if($instance->entity->name == 'Attendance')
                return true;
            return false;
        })->map(function($instance) {
            return new Attendance(['instance_id' => $instance->id]);
        });
    }


    /**
     * Add session for program.
     * @param $session
     * @return mixed
     */
    public function addSession($session) {
        $this->instance->instances()->save($session->instance);
        $this->instance->refresh();
    }

    /**
     * Remove session from the program.
     * @param $session
     */
    public function removeSession($session) {
        $this->instance->instances()->detach($session->instance->id);
        $this->instance->refresh();
    }

    /**
     * Get sessions which belongs to the program.
     * @return mixed
     */
    public function getSessions() {
        return $this->instance->instances->filter(function($instance) {
            if($instance->entity->name == 'Session')
                return true;
            return false;
        })->map(function($instance) {
            return new Session(['instance_id' => $instance->id]);
        });
    }

    /**
     * Gets all mentor sessions for the given mentor.
     * @param Mentor $mentor
     * @return mixed
     */
    public function getSessionsForMentor(Mentor $mentor) {
        $sessions = $this->getSessions();
        return $sessions->filter(function($session) use($mentor) {
            if($session->getMentor()->getId() == $mentor->getId())
                return true;
            return false;
        });
    }

    /**
     * Adds the founder to the program.
     * @param $founder
     */
    public function addFounder($founder) {
        $this->instance->instances()->save($founder->instance);
        $this->instance->refresh();
    }

    /**
     * Removes founder from program and deletes it.
     * @param $founder
     */
    public function removeFounder($founder) {
        $this->instance->instances()->detach($founder->instance->id);
        $this->instance->refresh();
        $founder->delete();
    }

    /**
     * Removes all founders from program.
     */
    public function removeAllFounders() {
        $this->instance->instances->filter(function($instance) {
            if($instance->entity->name == 'Founder')
                return true;
            return false;
        })->each(function($instance) {
            $instance->delete();
        });

        $this->instance->refresh();
    }


    /**
     * Get the list of all founders.
     * @return mixed
     */
    public function getFounders() {
        return $this->instance->instances->filter(function($instance) {
            if($instance->entity->name == 'Founder')
                return true;
            return false;
        })->map(function($instance) {
            return new Founder(['instance_id' => $instance->id]);
        });
    }

    // ------------- Team Members ------------------

    /**
     * Adds the founder to the program.
     * @param $founder
     */
    public function addTeamMember($member) {
        $this->instance->instances()->save($member->instance);
        $this->instance->refresh();
    }

    /**
     * Removes founder from program and deletes it.
     * @param $founder
     */
    public function removeTeamMember($member) {
        $this->instance->instances()->detach($member->instance->id);
        $this->instance->refresh();
        $member->delete();
    }

    /**
     * Removes all founders from program.
     */
    public function removeAllMembers() {
        $this->instance->instances->filter(function($instance) {
            if($instance->entity->name == 'TeamMember')
                return true;
            return false;
        })->each(function($instance) {
            $instance->delete();
        });

        $this->instance->refresh();
    }

    /**
     * Return the list of team members.
     * @return mixed
     */
    public function getTeamMembers() {
        return $this->instance->instances->filter(function($instance) {
            if($instance->entity->name == 'TeamMembers')
                return true;
            return false;
        })->map(function($instance) {
            return new TeamMember(['instance_id' => $instance->id]);
        });
    }

    // -------------- End of Team Members ----------

    /**
     * Add training to the program.
     * @param $training
     * @return mixed
     */
    public function addTraining($training) {
        $this->instance->instances()->save($training->instance);
        $this->instance->refresh();
        return $training;
    }


    /**
     * Remove the traning from the program.
     * @param $training
     */
    public function removeTraining($training) {
        $this->instance->instances()->detach($training->id);
        $this->instance->refresh();
    }


    /**
     * Lists all of the trainings for the program.
     * @return mixed
     */
    public function getTrainings() {
        return $this->instance->instances()->filter(function($instance) {
            if($instance->entity->name == 'Training')
                return true;
        })->map(function($instance) {
            return new Session(['instance_id' => $instance->id]);
        });
    }

    /**
     * Gets the mentor.
     * @return mixed
     */
    public function getMentors() {
        return $this->instance->parentInstances->filter(function($instance) {
            if($instance->entity->name == 'Mentor')
                return true;
        })->map(function($instance) {
            return new Mentor(['instance_id' => $instance->id]);
        });
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
            $entity = Entity::create(['name' => 'Program', 'description' => __('Accelerator Program')]);
        }

        return $entity;
    }

    /**
     * Must be overridden, because Program has the different constructor.
     * @param null $query
     * @return Program|Instance[]|\Illuminate\Database\Eloquent\Collection|Collection|null
     */
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

    public static function getProgramName($programType) {
        $programName = 'Undefined';

        switch ($programType) {
            case Program::$COLOSSEUM_SPORTS_TECH_SERBIA:
                // Colosseum
                $programName = __('Colosseum');
                break;
            case Program::$IMAGINEIF:
                // Imagineif!
                $programName = __('ImagineIF!');
                break;
            case Program::$RAISING_STARTS:
                // Raising starts
                $programName = __('Rising Starts');
                break;
            case Program::$PREDINKUBACIJA:
                // Predinkubacija
                $programName = __('Pre-Incubation');
                break;
            case Program::$INKUBACIJA_NTP:
                // Inkubacija NTP
                $programName = __('Incubation NTP');
                break;
            case Program::$INKUBACIJA_BITF:
                // Inkubacija BITF
                $programName = __('Incubation BITF');
                break;
            case Program::$RASTUCE_KOMPANIJE:
                // Rastuce kompanije
                $programName = __('Raising Companies');
                break;
            default:
                // Neodredjeno
                break;
        }

        return $programName;
    }

    public static function needsContract($programType) {
        // TODO: Define it for all program types.
        return true;
    }

    public static function needsPreselection($programType) {
        // TODO: Define it for all program types.
        return true;
    }

    public static function getAttributesDefinition($programType): Collection
    {
        $attributes = collect([]);
        $attributeGroups = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['program_type', __('Program Type'), 'integer', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['program_name', __('Program Name'), 'varchar', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['needs_preselection', __('Needs Preselection'), 'bool', NULL, 3]));
        $attributes->add(self::selectOrCreateAttribute(['needs_contract', __('Needs Contract'), 'bool', NULL, 4]));

        switch ($programType) {
            case Program::$COLOSSEUM_SPORTS_TECH_SERBIA:
                // Colosseum

                break;
            case Program::$IMAGINEIF:
                // Imagineif!

                break;
            case Program::$RAISING_STARTS:
                // Raising starts
                $attributeData = self::getRaisingStartsAttributesAndGroups();
                $attributeGroups = $attributeGroups->concat($attributeData['attributeGroups']);
                $attributes = $attributes->concat($attributeData['attributes']);

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
     * Get attributes for RAISING STARTS
     * @return Collection
     */
    public static function getRaisingStartsAttributesAndGroups(): Collection
    {
        $attributes = collect([]);
        $attributeGroups = collect([]);

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
        $attributes->add($ag_applicant->addAttribute(self::selectOrCreateAttribute(['rstarts_telephone', __('Telephone'), 'varchar', NULL, 8])));
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

        // ------------------------------------------- TIM ------------------------------------------- //
        // (TIM) Biće dodano prilikom kreiranja programa
        // (OSNIVACI - STRUKTURA) Biće dodano prilikom kreiranja programa

        $ag_tim = self::getAttributeGroup('rstarts_tim', __('Team'), 3);
        $attributeGroups->add($ag_tim);
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_founder_cvs', __('Founder CV\'s'), 'file', 'multiple', 16])));
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_founder_links', __('Founder Links'), 'text', NULL, 16])));
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_team_history', __('Team history'), 'text', NULL, 16])));
        $attributes->add($ag_tim->addAttribute(self::selectOrCreateAttribute(['rstarts_app_motive', __('Application Motive'), 'text', NULL, 17])));

        // -------------------------------------- POSLOVNA IDEJA ------------------------------------- //
        $ag_ideja = self::getAttributeGroup('rstarts_ideja', __('Idea'), 4);
        $attributeGroups->add($ag_ideja);
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_tagline', __('Tagline'), 'text', NULL, 18])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_solve_problem', __('Which Problem is Solved'), 'text', NULL, 19])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_targetted_market', __('Targetted Market'), 'text', NULL, 20])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_problem_solve', __('Whose Problem is Being Solved'), 'text', NULL, 21])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_which_product', __('Which Innovative Product is being Developed'), 'text', NULL, 22])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_benefits', __('What Benefits'), 'text', NULL, 23])));
        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_customer_problem_solve', __('How are the Customers solving the Problem?'), 'text', NULL, 24])));
        $howInnovative = self::selectOrCreateAttribute(['rstarts_how_innovative', __('How innovative'), 'select', NULL, 25]);
        if(count($howInnovative->getOptions()) == 0) {
            $howInnovative->addOption(['value' => 1, 'text' =>'Već postojeći proizvod/usluga']);
            $howInnovative->addOption(['value' => 2, 'text' =>'Poznat, ali nedovoljno primenjen proizvod i/ili usluga ']);
            $howInnovative->addOption(['value' => 3, 'text' => 'Poboljšan postojeći proizvod i/ili usluga']);
            $howInnovative->addOption(['value' => 4, 'text' => 'Značajno poboljšan postojeći proizvod i/ili usluga']);
            $howInnovative->addOption(['value' => 5, 'text' => 'Potpuno nov proizvod i/ili usluga']);
        }
        $attributes->add($ag_ideja->addAttribute($howInnovative));

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_clarification_innovative', __('Clarification Innovative'), 'text', NULL, 26])));

        $dev_phase_tech = self::selectOrCreateAttribute(['rstarts_dev_phase_tech', __('Development Phase Tech Development'), 'select', NULL, 27]);
        if(count($dev_phase_tech->getOptions()) == 0) {
            $dev_phase_tech->addOption(['value' => 1, 'text' => 'Ideja/prepoznat osnovni koncept']);
            $dev_phase_tech->addOption(['value' => 2, 'text' => 'Dokaz koncepta']);
            $dev_phase_tech->addOption(['value' => 3, 'text' => 'Razvijen prvi prototip / razvijena alpha verzija']);
            $dev_phase_tech->addOption(['value' => 4, 'text' => 'Razvijen drugi prototip / razvijena beta verzija']);
            $dev_phase_tech->addOption(['value' => 5, 'text' => 'MVP 1.0']);
            $dev_phase_tech->addOption(['value' => 6, 'text' => 'Stabilna prva verzija proizvoda koja se kontinuirano unapredjuje']);
        }
        $attributes->add($ag_ideja->addAttribute($dev_phase_tech));

        $dev_phase_business = self::selectOrCreateAttribute(['rstarts_dev_phase_bussines', __('Development Phase Business Development'), 'select', NULL, 28]);
        if(count($dev_phase_business->getOptions()) == 0) {
            $dev_phase_business->addOption(['value' => 1, 'text' => 'Hipoteza o mogućim potrebama']);
            $dev_phase_business->addOption(['value' => 2, 'text' => 'Indetifikovane potrebe na tržistu']);
            $dev_phase_business->addOption(['value' => 3, 'text' => 'Uspostavljene prve povratne informacije sa tržista']);
            $dev_phase_business->addOption(['value' => 4, 'text' => 'Potvrdjeni problem / potrebe nekoliko kupaca i / ili korisnika']);
            $dev_phase_business->addOption(['value' => 5, 'text' => 'Utvrđeno interesovanje za proizvod i uspostavljeni odnosi sa ciljnom grupom']);
            $dev_phase_business->addOption(['value' => 6, 'text' => 'Prednosti rešenja potvrđene prvim testiranjem kupaca i/ili partnerstvom za pristup tržištu ']);
            $dev_phase_business->addOption(['value' => 7, 'text' => 'Kupci u dužem/kontinuiranom ispitivanju proizvoda i / ili ostvarene prve probne prodaje u periodu ne dužem od 6 meseci']);
            $dev_phase_business->addOption(['value' => 8, 'text' => 'U prethodnih 6 meseci generisan prihod veći od 10 hiljada ili 15 hiljada švajcarskih franaka']);
            $dev_phase_business->addOption(['value' => 9, 'text' => 'Rasprostranjena prodaja proizvoda / širenje tržista']);
        }
        $attributes->add($ag_ideja->addAttribute($dev_phase_business));

        $ippactivities = self::selectOrCreateAttribute(['rstarts_intellectual_property', __('Intellectual Property Protection Activities'), 'select', NULL, 29]);
        if(count($ippactivities->getOptions()) == 0) {
            $ippactivities->addOption(['value' => 1, 'text' => 'Inicijalno istraživanje (konsultacije sa Zavodom za IP)']);
            $ippactivities->addOption(['value' => 2, 'text' => 'Dobijen Izveštaj o obavljenom istraživanju od strane Zavoda za zaštitu intelektualne svojine']);
            $ippactivities->addOption(['value' => 3, 'text' => 'Podneta aplikacija za zaštitu nekog prava IP']);
            $ippactivities->addOption(['value' => 4, 'text' => 'Zaštićen logo, autorsko delo i neko srodno pravo']);
            $ippactivities->addOption(['value' => 5, 'text' => 'Zaštićen logo, autorsko delo i neko srodno pravo']);
        }
        $attributes->add($ag_ideja->addAttribute($ippactivities));

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_research', __('Research Description'), 'text', NULL, 30])));

        $innovative_area = self::selectOrCreateAttribute(['rstarts_innovative_area', __('Innovative Area'), 'select', NULL, 31]);
        if(count($innovative_area->getOptions()) == 0) {
            $innovative_area->addOption(['value' => 1, 'text' => 'Masovni podaci (Big data) i poslovna analitika (Business analytics)']);
            $innovative_area->addOption(['value' => 2, 'text' => 'Računarstvo u oblaku (Cloud computing)']);
            $innovative_area->addOption(['value' => 3, 'text' => 'Internet stvari (Internet of Things)']);
            $innovative_area->addOption(['value' => 4, 'text' => 'Razvoj softvera']);
            $innovative_area->addOption(['value' => 5, 'text' => 'Ugrađeni sistemi (Embedded Systems)']);
            $innovative_area->addOption(['value' => 6, 'text' => 'Visoko tehnološka poljoprivreda']);
            $innovative_area->addOption(['value' => 7, 'text' => 'Hrana sa dodatom vrednošću']);
            $innovative_area->addOption(['value' => 8, 'text' => 'Održiva poljoprivreda i proizvodnja hrane']);
            $innovative_area->addOption(['value' => 9, 'text' => 'Kreativna Digitalna Audiovizuelna Produkcija ']);
            $innovative_area->addOption(['value' => 10, 'text' => 'Industrija video igara 46']);
            $innovative_area->addOption(['value' => 11, 'text' => 'Pametna i aktivna ambalaža']);
            $innovative_area->addOption(['value' => 12, 'text' => 'Mašine specifične namene']);
            $innovative_area->addOption(['value' => 13, 'text' => 'Informacije u službi pametnog upravljanja-industrija 4.0']);
            $innovative_area->addOption(['value' => 14, 'text' => 'Premijum alatnice i komponente za atomobilsku, železničku i avionsku industriju']);
            $innovative_area->addOption(['value' => 15, 'text' => 'Uređaji za sagorevanje na eco-friendly i održivim gorivima']);
            $innovative_area->addOption(['value' => 16, 'text' => 'Rešenja za pametna okruženja']);
        }
        $attributes->add($ag_ideja->addAttribute($innovative_area));

        $attributes->add($ag_ideja->addAttribute(self::selectOrCreateAttribute(['rstarts_business_plan', __('Business Plan'), 'text', NULL, 32])));

        // ------------------------------------------------- VAŠA STARTAP PRIČA ------------------------------------------------ //
        $ag_startup_story = self::getAttributeGroup('startup_story', 'Vaša startup priča', 5);
        $attributeGroups->add($ag_startup_story);

        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_statup_progress', 'Startup napredak', 'text', NULL, 33])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_files', 'Prilozeni fajlovi', 'file', 'multiple', 34])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_links', 'Prilozeni linkovi', 'varchar', 'multiple', 35])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_mentor_program_history', 'Da li ste vec ucestvovali u programu', 'text', NULL, 36])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_financing_sources', 'Da li ste vec dosad prikupili bilo koji izvor finansiranja', 'text', NULL, 37])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_financing_proof_files', 'Dokazni fajlovi', 'file', 'multiple', 38])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_financing_proof_links', 'Dokazni linkovi', 'varchar', NULL, 39])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_expectations', 'Šta očekujete od učešća u programu', 'text', NULL, 40])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_howmuchmoney', 'Koliko sredstava potrebno', 'text', NULL, 41])));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_linkclip', 'Link video klipa', 'varchar', NULL, 42])));

        $howdiduhear = self::selectOrCreateAttribute(['rstarts_howdiduhear', 'Kako ste culi za nas', 'select', NULL, 43]);
        if(count($howdiduhear->getOptions()) == 0) {
            $howdiduhear->addOption(['value' => 1, 'text' => 'Zvanične društvene mreže NTP Beograd i Raising Starts']);
            $howdiduhear->addOption(['value' => 2, 'text' => 'E-mail/newsletter NTP Beograd']);
            $howdiduhear->addOption(['value' => 3, 'text' => 'Webstranice NTP Beograd']);
            $howdiduhear->addOption(['value' => 4, 'text' => 'Mediji (TV, radio)']);
            $howdiduhear->addOption(['value' => 5, 'text' => 'Dodati opciju - Other']);
        }

        $attributes->add($ag_startup_story->addAttribute($howdiduhear));
        $attributes->add($ag_startup_story->addAttribute(self::selectOrCreateAttribute(['rstarts_other_sources', "Dodatni izvori informisanja", 'varchar', NULL, 44])));

        $ag_dodatna_dokumentacija = self::getAttributeGroup('dodatna_dokumentacija', 'Dodatna dokumentacija', 7);
        $attributeGroups->add($ag_dodatna_dokumentacija);

        $attributes->add($ag_dodatna_dokumentacija->addAttribute(self::selectOrCreateAttribute(['rstarts_dodatni_dokumenti', 'Dodatni dokumenti', 'file', 'multiple', 45])));


        return collect(
            [
                'attributes' => $attributes,
                'attributeGroups' => $attributeGroups
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

    public static function getRastuceAttributes() {
        $attributes = collect([]);

        return $attributes;
    }




}
