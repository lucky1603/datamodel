<?php

namespace App\Business;

use App\Attribute;
use App\AttributeGroup;
use App\Entity;
use App\Instance;
use App\Mail\DemoDayNotification;
use App\Report;
use \Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Program extends SituationsModel
{
    public static int $COLOSSEUM_SPORTS_TECH_SERBIA = 0;
    public static int $IMAGINEIF = 1;
    public static int $RAISING_STARTS = 2;
    public static int $PREDINKUBACIJA = 3;
    public static int $INKUBACIJA_NTP = 4;
    public static int $INKUBACIJA_BITF = 5;
    public static int $RASTUCE_KOMPANIJE = 6;

    public static int $PROGRAM_UNDEFINED = 0;
    public static int $PROGRAM_ACTIVE = -1;
    public static int $PROGRAM_APP_DENIED = -2;
    public static int $PROGRAM_SUSPENDED = -3;
    public static int $PROGRAM_FINISHED = -4;
    public static int $PROGRAM_APPNOTSENT = -5;


    public ?Workflow $workflow = null;

    /**
     * Constructor with arguments
     * @param $programType - Type of program, integer
     * @param null $data - Array of parameters, if any. Default is null.
     */
    public function __construct($data = null)
    {
        if(isset($data['instance_id'])) {
            $this->instance = Instance::find($data['instance_id']);
        } else {
            $entity = $this->getEntity();
            $attributeData = static::getAttributesDefinition();

            $attributes = $attributeData['attributes'];
            $attributeGroups = $attributeData['attributeGroups'];

            $this->instance = Instance::create(['entity_id' => $entity->id]);
            $this->instance->setAttributes($attributes->map(function($attribute) {
                return $attribute->id;
            }));

            foreach($attributeGroups as $attributeGroup) {
                $this->instance->attribute_groups()->sync($attributeGroup, false);
            }

            $this->updateProgramData();
            $this->setAttributes($data);
        }

        if(isset($data['init_workflow']) && $data['init_workflow'] == true) {
            $this->initWorkflow();
        }

        $this->setStatus($this->getValue('program_status') ?? 1);

    }

    /**
     * Ova funkcija i dohvata i inicijalizuje workflow.
     * @return Workflow|null
     */
    public function getWorkflow(): ?Workflow
    {
        if($this->workflow != null)
            return $this->workflow;

        $this->workflow = $this->instance->instances->filter(function($instance) {
            return $instance->entity->name === 'Workflow';
        })->map(function($instance) {
            return WorkflowFactory::resolve($instance->id);
        })->first();

        // if($this->workflow == null) {
        //     $this->initWorkflow();
        // }

        return $this->workflow;
    }

    public function removeWorkflows() {
        $this->instance->instances->each(function($instance) {
            if($instance->entity->name == 'Workflow')
                $instance->delete();
        });

        $this->workflow = null;
    }

    public function setWorkflow(Workflow $workflow) {
        $this->removeWorkflows();
        $this->workflow = $workflow;
        $this->instance->instances()->attach($workflow->getId());
        $this->instance->refresh();
    }

    /**
     * Gets the profile the program belongs to.
     * @return Profile
     */
    public function getProfile(): ?Profile
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
        $this->instance->instances()->detach($attendance->getId());
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
     * Remove the named founder.
     * @param $founderName
     */
    public function removeFounderByName($founderName) {
        $founderToRemove = $this->getFounderByName($founderName);
        if($founderToRemove != null) {
            $this->removeFounder($founderToRemove);
        }
    }


    /**
     * Gets founder by the given name.
     * @param $founderName
     * @return mixed
     */
    public function getFounderByName($founderName) {
        return $this->getFounders()->filter(function($founder) use($founderName) {
            if($founder->getValue('founder_name') == $founderName)
                return true;
            return false;
        })->first();
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

    /**
     * Update founders collection from the supplied data object.
     * @param $foundersData
     */
    public function updateFounders($foundersData) {
        $founders = $this->getFounders();
        if(count($foundersData) == 0)
            return;

        $foundersCount = $founders->count();
        $foundersDataCount = count($foundersData);

        // $count = min($foundersCount, $foundersDataCount);

        if($foundersCount != $foundersDataCount) {
            // Delete all.
            $this->removeAllFounders();
            // Add again.
            for($i = 0; $i < $foundersDataCount; $i++) {
                $fData = $foundersData[$i];
                $this->addFounder(new Founder([
                    'founder_name' => $fData['founder_name'],
                    'founder_part' => $fData['founder_part'],
                    'founder_university' => $fData['founder_university'] ?? '',
                ]));
            }
        } else {
            // Update existing.
            $counter = 0;
            foreach($founders as $founder) {
                $founder->setValue('founder_name', $foundersData[$counter]['founder_name']);
                $founder->setValue('founder_part', $foundersData[$counter]['founder_part']);
                $founder->setValue('founder_university', $foundersData[$counter]['founder_university'] ?? '');
                $counter++;
            }
        }

    }

    // ------------- Team Members ------------------

    /**
     * Adds the team member to the program.
     * @param $founder
     */
    public function addTeamMember($member) {
        $this->instance->instances()->save($member->instance);
        $this->instance->refresh();
    }

    /**
     * Removes team member from program and deletes it.
     * @param $founder
     */
    public function removeTeamMember($member) {
        $this->instance->instances()->detach($member->instance->id);
        $this->instance->refresh();
        $member->delete();
    }

    /**
     * Removes the named team member.
     * @param $memberName
     */
    public function removeTeamMemberByName($memberName) {
        $memberToRemove = $this->getTeamMemberByName($memberName);
        if($memberToRemove != null) {
            $this->removeTeamMember($memberToRemove);
        }
    }

    /**
     * Gets the team member by its name.
     * @param $memberName
     * @return mixed
     */
    public function getTeamMemberByName($memberName) {
        return $this->getTeamMembers()->filter(function($member) use($memberName) {
            if($member->getValue('team_member_name') == $memberName)
                return true;
            return false;
        })->first();
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
            if($instance->entity->name == 'TeamMember')
                return true;
            return false;
        })->map(function($instance) {
            return new TeamMember(['instance_id' => $instance->id]);
        });
    }

    /**
     * Updates the team members from the given data structure.
     * @param $membersData
     */
    public function updateTeamMembers($membersData) {
        $members = $this->getTeamMembers();
        if(count($membersData) == 0)
            return;

        $membersCount = $members->count();
        $membersDataCount = count($membersData);

        // $count = min($membersCount, $membersDataCount);

        if($membersCount != $membersDataCount) {
            // Delete all.
            $this->removeAllMembers();
            // Add again.
            for($i = 0; $i < $membersDataCount; $i ++) {
                $mData = $membersData[$i];
                $this->addTeamMember(new TeamMember([
                    'team_member_name' => $mData['team_member_name'],
                    'team_education' => $mData['team_education'],
                    'team_role' => $mData['team_role'],
                    'team_other_job' => $mData['team_other_job']
                ]));
            }

        } else {
            // Update existing.
            $counter = 0;
            foreach($members as $member) {
                $member->setValue('team_member_name', $membersData[$counter]['team_member_name']);
                $member->setValue('team_education', $membersData[$counter]['team_education']);
                $member->setValue('team_role', $membersData[$counter]['team_role']);
                $member->setValue('team_other_job', $membersData[$counter]['team_other_job']);
                $counter++;
            }
        }

        // $counter = 0;
        // foreach($members as $member)
        // {
        //     $memberData = $membersData[$counter];

        //     $member->setValue('team_member_name', $memberData['team_member_name']);
        //     $member->setValue('team_education', $memberData['team_education']);
        //     $member->setValue('team_role', $memberData['team_role']);
        //     $member->setValue('team_other_job', $memberData['team_other_job']);
        //     $counter++;
        // }

        // // Obrisi suvisne clanove
        // if($count < $membersCount) {
        //     $ids = [];
        //     for($i = $membersCount - 1; $i >= $count; $i-- )
        //     {
        //         $ids[] = $members->get($i)->getId();
        //     }

        //     $members->filter(function($member) use($ids) {
        //         if(in_array($member->getId(), $ids))
        //             return true;
        //         return false;
        //     })->each(function($member) {
        //         $this->removeTeamMember($member);
        //     });
        // }

        // // Add new members, if membersData is larger than the current
        // // members' collection.
        // if($count < $membersDataCount)  {
        //     for($i = $count; $i < $membersDataCount; $i++) {
        //         $member = $membersData[$i];

        //         $this->addTeamMember(new TeamMember([
        //             'team_member_name' => $member['team_member_name'],
        //             'team_education' => $member['team_education'],
        //             'team_role' => $member['team_role'],
        //             'team_other_job' => $member['team_other_job']
        //         ]));
        //     }
        // }
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
        return $this->instance->instances->filter(function($instance) {
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
     * Deletes the program and all of its instances.
     * WARNING: It is strictly TECHNICAL delete, used
     * in the process of testing and bug fixing.
     * It is by no means meant to do this regularely in
     * the course of the business process.
     */

    public function delete()
    {
        DB::table('program_caches')->where('program_id', $this->instance->id)->delete();

        parent::delete();
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
                return ProgramFactory::resolve($instance->id);
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

            return ProgramFactory::resolve($instance->id);
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

    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);
        $attributeGroups = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['program_type', __('Program Type'), 'integer', NULL, 1]));
        $attributes->add(self::selectOrCreateAttribute(['program_name', __('Program Name'), 'varchar', NULL, 2]));
        $attributes->add(self::selectOrCreateAttribute(['program_status', __('Program Status'), 'integer', NULL, 3]));
        $ntp = self::selectOrCreateAttribute(['ntp', 'NTP koji daje podršku', 'select', NULL, 4]);
        if(count($ntp->getOptions()) == 0) {
            $ntp->addOption(['value' => 1, 'text' => 'Naučno-tehnološki park Beograd']);
            $ntp->addOption(['value' => 2, 'text' => 'Naučno-tehnološki park Niš']);
            $ntp->addOption(['value' => 3, 'text' => 'Naučno-tehnološki park Čačak']);
        }
        $attributes->add($ntp);

        $ag_general = self::getAttributeGroup('rstarts_general',__('General Data'), 1);
        $ag_general->addAttribute($ntp);

        return collect([
            'attributeGroups' => $attributeGroups,
            'attributes' => $attributes
        ]);
    }

    /**
     * Privremena funkcija za dodavanje atributa, neophodnih za statistiku, svim programima.
     */
    public static function addStatisticAttributes() {
        $attribute = self::selectOrCreateAttribute(['iznos_prihoda', __('Income Amount'), 'double', NULL, 201]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['iznos_izvoza', __('Export Amount'), 'double', NULL, 202]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['broj_zaposlenih', __('Number of Employees'), 'integer', NULL, 203]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['broj_angazovanih', __('Number of Engaged People'), 'integer', NULL, 204]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['broj_angazovanih_zena', __('Number of Engaged Women'), 'integer', NULL, 211]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['iznos_placenih_poreza', __('Amount of Payed Taxes'), 'double', NULL, 205]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['iznos_ulaganja_istrazivanje_razvoj', __('Amount of Investment in Research and Development'), 'double', NULL, 205]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['broj_malih_patenata', __('Small Patents Number'), 'integer', NULL, 206]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['broj_patenata', __('Patents Number'), 'integer', NULL, 207]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['broj_autorskih_dela', __("Author's Works Number"), 'integer', NULL, 208]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['broj_inovacija', __("Innovation Count"), 'integer', NULL, 209]);
        Program::addOverallAttribute($attribute, 0);

        $attribute = self::selectOrCreateAttribute(['countries', __('Countries'), 'select', 'multiselect', 210]);
        if(count($attribute->getOptions()) == 0) {
            $countries = DB::table('countries')->select()->get();
            foreach($countries as $country) {
                $attribute->addOption(['value' => $country->id, 'text' => $country->country]);
            }
        }

        Program::addOverallAttribute($attribute);

        $attribute = self::selectOrCreateAttribute(['statistic_sent', __('Statistic Sent'), 'bool', NULL, 212]);
        Program::addOverallAttribute($attribute, false);

    }

    public static function removeStatisticalAttributes() {
        $attNames = [
            'iznos_prihoda',
            'iznos_izvoza',
            'broj_zaposlenih',
            'broj_angazovanih',
            'broj_angazovanih_zena',
            'iznos_placenih_poreza',
            'iznos_ulaganja_istrazivanje_razvoj',
            'broj_malih_patenata',
            'broj_patenata',
            'broj_autorskih_dela',
            'broj_inovacija',
            'countries',
            'statistic_sent'
        ];

        foreach ($attNames as $attName) {
            $attribute = Attribute::where('name', $attName)->first();
            Program::removeOverallAttribute($attribute);
        }
    }

    public static function getRastuceAttributes(): Collection
    {
        $attributes = collect([]);

        return $attributes;
    }

    public function getStatus()
    {
        return $this->getValue('program_status');
    }

    public function setStatus(int $status) {
        if($status > 0 && isset($this->workflow)) {
            $this->workflow->setCurrentIndex($status);
        }
        $this->setValue('program_status', $status);
    }

    ///
    /// Reports part
    ///

    public function getReports() {
        return $this->instance->reports;
    }

    public function addReport(Report $report) {
        $this->instance->reports()->save($report);
        $this->instance->refresh();
    }

    public function removeReport(Report $report) {
        $report->delete();
        $this->instance->refresh();
    }

    public function removeAllReports() {
        foreach($this->instance->reports as $report) {
            $report->delete();
        }

        $this->instance->refresh();

    }

    public function hasReportAlert() {
        if($this->getStatus() != Program::$PROGRAM_ACTIVE) {
            return false;
        }

        $reports = $this->getReports();
        $hasAlert = false;
        foreach($reports as $report) {
            if($report->status == Report::$WARNING)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the textual representation of the status text.
     * @return string
     */
    public function getStatusText(): string
    {
        return $this->getTextForStatus($this->getStatus());
    }


    public function initReports() {}


    /**
     * Determines if the program is at the state when the company can participate in events.
     * Abstract function - each type of program has its own implementation.
     * @return bool
     */
    public function isEventCandidate() : bool { return false; }

    /**
     * Initializes program workflow.
     */
    public function initWorkflow() {}

    /**
     * Updates the program data.
     */
    protected function updateProgramData() {}

    /**
     * Returns the textual value for the given status value.
     * @param $status
     * @return string
     */
    protected function getTextForStatus($status): string
    {
        switch($status) {
            case 0:
                return "Nedefinisan";
            case -1:
                return "U PROGRAMU";
            case -2:
                return "Odbijen";
            case -3:
                return "Prekid";
            case -4:
                return "Završetak";
            case -5:
                return "Odustao";
            default:
                return "Nedefinisano";
        }
    }

    public function getYear() {
        $year = 0;
        $workflow = $this->getWorkflow();
        if($workflow != null) {
            $contract = $this->getWorkflow()->getPhases()->filter(function($phase) {
                return $phase instanceof Contract;
            })->first();

            if($contract != null) {
                $contract_date = $contract->getValue('signed_at');
                if($contract_date != '') {
                    $year = date("Y", strtotime($contract_date));
                } else {
                    $year = date('Y', strtotime($this->instance->created_at));
                    $year += 1;
                }

            } else {
                $year = date('Y', strtotime($this->instance->created_at));
                $year += 1;
            }
        }
        else {
            $year = date('Y', strtotime($this->instance->created_at));
            $year += 1;
        }

        return $year;
    }

    public static function makeCache() {
        DB::table('program_caches')->delete();

        Program::find()->each(function($program) {
            if($program == null)
                return true;

            $program->initWorkflow();

            $profile = $program->getProfile();
            if($profile == null)
                return true;

            $logo = $profile->getValue('profile_logo');
            if($logo == null || $logo == ['filename' => '', 'filelink' => '']) {
                $logo = asset('images/custom/nophoto2.png', false);
            } else {
                $logo = $logo['filelink'];
            }

            $year = 1996;
            $workflow = $program->getWorkflow();
            if($workflow != null) {
                $contract = $program->getWorkflow()->getPhases()->filter(function($phase) {
                    return $phase instanceof Contract;
                })->first();

                if($contract != null) {
                    $contract_date = $contract->getValue('signed_at');
                    if($contract_date != '') {
                        $year = date("Y", strtotime($contract_date));
                    } else {
                        $year = date('Y', strtotime($program->instance->created_at));
                        $year += 1;
                    }

                } else {
                    $year = date('Y', strtotime($program->instance->created_at));
                    $year += 1;
                }
            }
            else {
                $year = date('Y', strtotime($program->instance->created_at));
                $year += 1;
            }

            DB::table('program_caches')->insert([
                'program_id' => $program->getId(),
                'program_type' => $program->getValue('program_type'),
                'program_name' => $program->getValue('program_name'),
                'program_type_text' => $program->getText('program_name'),
                'profile_name' => $profile->getValue('name'),
                'profile_logo' => $logo,
                'profile_type' => $profile->getValue('is_company') ? 1 : 0, // 1 - If it's a company, 0 - if it's a startup
                'program_status' => $program->getStatus(),
                'program_status_text' => $program->getStatusText(),
                'ntp' => $program->getValue('ntp') ?? 1,
                'ntp_text' => $program->getText('ntp') ?? '',
                'session_count' => $program->getSessions()->count(),
                'workshop_count' => $program->getAttendances()->filter(function($attendance) { return $attendance->getTraining()->getValue('training_type') == 1; })->count(),
                'year' => $year,
                'membership_type' => $profile->getValue('membership_type') ?? 0
            ]);
        });
    }

    public static function closeUnsentForms() {
        Program::find()->filter(function($program) {
            $created = $program->instance->created_at;
            $createdYear = date("Y", strtotime($created));
            $currentYear = date("Y", strtotime(now()));
            return ( $program->getStatus() == 1 && ($createdYear != $currentYear));
      })->map(function($program) {
        $program->setStatus(-5);
        $situation = new Situation([
            'name' => 'Istekao rok',
            'description' => 'Rok za slanje prijave je istekao',
            'sender' => 'NTP'
        ]);

        $program->addSituation($situation);

        $profile = $program->getProfile();
        if($profile != null) {
            $profile->addSituation($situation);
        }
      });
    }



    public static function migrateToNewModel()
    {
        // Zameni vrednosti atributa - status profila
        $options = [
            1 =>  __('gui-select.PS-New'),
            2 => __('gui-select.PS-Active'),
            3 => __('gui-select.PS-Inactive'),
            4 => __('gui-select.PS-Suspended')
        ];

        $attribute = Attribute::where('name', 'profile_status')->first();
        $attribute->setOptions($options);

        // Promeni vrednosti statusa profila i programa
        Program::find()->each(function($program) {
            $profile = $program->getProfile();
            $profile_status = $profile->getValue('profile_status');

            if(in_array($profile_status, [1,2])) {
                $profile->setValue('profile_status', 1);
            }

            // Ako je aktivan program u fazi prijave i selekcije.
            if($profile_status == 3) {
                // Prebacujemo statuse profila na 2, statuse programa ne diramo
                $profile->setValue('profile_status', 2);
            }

            // Ako je u programu
            if($profile_status == 4) {
                $profile->setValue('profile_status', 2);
                $program->setStatus(Program::$PROGRAM_ACTIVE);
            }

            // Ako je odbijena prijava.
            if($profile_status == 5) {
                $profile->setValue('profile_status', 4);
                $program->setStatus(Program::$PROGRAM_APP_DENIED);
            }

            // Transfer situacija
            if($program->getSituations()->count() == 0) {
                $situations = $profile->getSituations();
                for($i = 1; $i < $situations->count(); $i++) {
                    $situation = $situations[$i];
                    $program->addSituation($situation);
                }
            }

        });
    }

    public static function transferSituations() {
        Program::find()->each(function($program) {
            $profile = $program->getProfile();
            $situations = $profile->getSituations();
            for($i = 1; $i < $situations->count(); $i++) {
                $situation = $situations[$i];
                $program->addSituation($situation);
            }
        });
    }


}
