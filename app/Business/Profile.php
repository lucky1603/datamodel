<?php


namespace App\Business;


use App\Attribute;
use App\Entity;
use App\Instance;
use Illuminate\Support\Facades\DB;

class Profile extends SituationsModel
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
            $entity = Entity::create(['name' => 'Profile', 'description' => __('Client Profile')]);
        }

        return $entity;
    }

    /**
     * Sets the attributes either with data or with the default values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'name' => '',
                'is_company' => false,
                'id_number' => '',
                'contact_person' => '',
                'contact_email' => '',
                'contact_phone' => '',
                'address' => '',
                'university' => 0,
                'short_ino_desc' => '',
                'business_branch' => 0,
                'reason_contact' => 0,
                'note' => '',
                'profile_status' => 0,
            ];
        }

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

        $attributes[] = self::selectOrCreateAttribute(['name', __('Name'), 'varchar', NULL, 1]);
        $attributes[] = self::selectOrCreateAttribute(['is_company', __("Is it a company"), 'bool', NULL, 2]);
        $attributes[] = self::selectOrCreateAttribute(['id_number', __('ID Number'), 'varchar', NULL, 3]);
        $attributes[] = self::selectOrCreateAttribute(['contact_person', __('Contact Person'), 'varchar', NULL, 4]);
        $attributes[] = self::selectOrCreateAttribute(['contact_email', __('Email'), 'varchar', ['ui'=>'email'], 5]);
        $attributes[] = self::selectOrCreateAttribute(['password', __('Password'), 'varchar', ['ui' => 'password'], 6]);
        $attributes[] = self::selectOrCreateAttribute(['contact_phone', __('Phone Number'), 'varchar', NULL, 7]);
        $attributes[] = self::selectOrCreateAttribute(['address', __('Address'), 'varchar', NULL, 8]);

        $university = self::selectOrCreateAttribute(['university', 'Fakultet', 'select', NULL, 9]);
        if(count($university->getOptions()) == 0) {
            $university->addOption(['value' => 0, 'text' => __('gui-select.U-None')]);
            $university->addOption(['value' => 1, 'text' => __('gui-select.U-Architecture')]);
            $university->addOption(['value' => 2, 'text' => __('gui-select.U-Economics')]);
            $university->addOption(['value' => 3, 'text' => __('gui-select.U-Electrotehnics')]);
            $university->addOption(['value' => 4, 'text' => __('gui-select.U-Law')]);
            $university->addOption(['value' => 5, 'text' => __('gui-select.U-FON')]);
            $university->addOption(['value' => 6, 'text' => __('gui-select.U-FPN')]);
            $university->addOption(['value' => 7, 'text' => __('gui-select.U-Forestry')]);
        }
        $attributes[] = $university;

        $attributes[] = self::selectOrCreateAttribute(['short_ino_desc', 'Kratak opis inovacije', 'text', NULL, 10]);

        $business_branch = self::selectOrCreateAttribute(['business_branch', 'Osnovna aktivnost', 'select', NULL, 11]);
        if(count($business_branch->getOptions()) == 0) {
            $business_branch->addOption(['value' => 1, 'text' => __('gui-select.BB-IOT')]);
            $business_branch->addOption(['value' => 2, 'text' => __('gui-select.BB-EnEff')]);
            $business_branch->addOption(['value' => 3, 'text' => __('gui-select.BB-AI')]);
            $business_branch->addOption(['value' => 4, 'text' => __('gui-select.BB-NewMat')]);
            $business_branch->addOption(['value' => 5, 'text' => __('gui-select.BB-TechSport')]);
            $business_branch->addOption(['value' => 6, 'text' => __('gui-select.BB-EcoTrans')]);
            $business_branch->addOption(['value' => 7, 'text' => __('gui-select.BB-RoboAuto')]);
            $business_branch->addOption(['value' => 8, 'text' => __('gui-select.BB-Tourism')]);
            $business_branch->addOption(['value' => 9, 'text' => __('gui-select.BB-Education')]);
            $business_branch->addOption(['value' => 10,'text' => __('gui-select.BB-MediaGaming')]);
            $business_branch->addOption(['value' => 11, 'text' => __('gui-select.BB-MedTech')]);
            $business_branch->addOption(['value' => 12, 'text' => __('gui-select.BB-Other')]);
        }
        $attributes[] = $business_branch;

        $reason_contact = self::selectOrCreateAttribute(['reason_contact', __('Reason for Contact'), 'select', NULL, 12]);
        if(count($reason_contact->getOptions()) == 0) {
            $reason_contact->addOption(['value' => 1, 'text' => __('gui-select.RC-Reason1')]);
            $reason_contact->addOption(['value' => 2, 'text' => __('gui-select.RC-Reason2')]);
            $reason_contact->addOption(['value' => 3, 'text' => __('gui-select.RC-Reason3')]);
        }
        $attributes[] = $reason_contact;

        $attributes[] = self::selectOrCreateAttribute(['note', __('Note'), 'text', NULL, 13]);

        $status = self::selectOrCreateAttribute(['profile_status', __('Profile Status'), 'select', NULL, 14]);
        if(count($status->getOptions()) == 0) {
            $status->addOption(['value' => 0, 'text' => __('gui-select.PS-Uninitialized')]);
            $status->addOption(['value' => 1, 'text' => __('gui-select.PS-Mapped')]);
            $status->addOption(['value' => 2, 'text' => __('gui-select.PS-Interest')]);
            $status->addOption(['value' => 3, 'text' => __('gui-select.PS-Application')]);
            $status->addOption(['value' => 4, 'text' => __('gui-select.PS-InProgram')]);
            $status->addOption(['value' => 5, 'text' => __('gui-select.PS-Rejected')]);
        }
        $attributes[] = $status;

        return $attributes;
    }

    /////
    /// Situations part
    ///

    public function addSituationByData($situationType, $params)
    {
        $data = [];
        $situation = null;

        switch($situationType) {
            case __('Interest'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-INTEREST'),
                    'sender' => $this->getAttribute('name')->getValue()
                ];

                break;
            case __('Mapped'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-MAPPED'),
                    'sender' => 'NTP'
                ];

                break;
            case __('Applying'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-APPLYING'),
                    'sender' => $this->getAttribute('name')->getValue()
                ];

                $situation = new Situation($data);
                $situation->addAttribute(self::selectOrCreateAttribute(['program_type', 'Tip programa', 'integer', NULL, 1]));
                $situation->addAttribute(self::selectOrCreateAttribute(['program_name', 'Ime programa', 'varchar', NULL, 2]));

                break;

            case __('Application Sent'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-APPSENT'),
                    'sender' => $this->getAttribute('name')->getValue()
                ];

                $situation = new Situation($data);
                $situation->addAttribute(self::selectOrCreateAttribute(['program_type', 'Tip programa', 'integer', NULL, 1]));
                $situation->addAttribute(self::selectOrCreateAttribute(['program_name', 'Ime programa', 'varchar', NULL, 2]));
                break;
            case __('Preselection needed'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-PRESELECTION'),
                    'sender' => 'NTP'
                ];

                $situation = new Situation($data);
                $situation->addAttribute(self::selectOrCreateAttribute(['program_type', 'Tip programa', 'integer', NULL, 1]));
                $situation->addAttribute(self::selectOrCreateAttribute(['program_name', 'Ime programa', 'varchar', NULL, 2]));
                break;
            case __('Preselection Done'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-PRESELECTION-DONE', [
                        'client' => $this->getAttribute('name')->getValue(),
                        'program' => $this->getActiveProgram()->getAttribute('program_name')->getValue()
                    ]),
                    'sender' => 'NTP'
                ];

                $situation = new Situation($data);
                $situation->addAttribute(self::selectOrCreateAttribute(['preselection_passed', __("Preselection Passed"), 'bool', NULL, 5]));
                break;
            case __('Demo Day Passed'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-DEMODAY-DONE', [
                        'client' => $this->getValue('name')
                    ]),
                    'sender' => 'NTP'
                ];

                $situation = new Situation($data);
                $situation->addAttribute(self::selectOrCreateAttribute(['demoday_passed', __("Demo Day   Passed"), 'bool', NULL, 5]));
                break;
            case __('Ready for Selection'):
                $data = [
                    'name' => $situationType,
                    'description' => __('gui-situations.PROFILE-SELECTION', [
                        'client' => $this->getAttribute('name')->getValue(),
                        'program' => $this->getActiveProgram()->getAttribute('program_name')->getValue()
                    ]),
                    'sender' => 'NTP'
                ];
                break;
            case __('Selection Finished'):
                $data = [
                    'name' => $situationType,
                    'sender' => 'NTP',
                    'description' => __('gui-situations.PROFILE-SELECTION-DONE', [
                        'client' => $this->getAttribute('name')->getValue(),
                        'program' => $this->getActiveProgram()->getAttribute('program_name')->getValue()
                    ]),
                ];

                $situation = new Situation($data);
                $situation->addAttribute(self::selectOrCreateAttribute(['selection_passed', __("Selection Passed"), 'bool', NULL, 5]));
                break;

            case __('Contract Signing'):
                $data = [
                    'name' => $situationType,
                    'sender' => 'NTP',
                    'description' => __('gui-situations.PROFILE-CONTRACT-SIGNING', [
                        'client' => $this->getAttribute('name')->getValue(),
                        'program' => $this->getActiveProgram()->getAttribute('program_name')->getValue()
                    ]),
                ];
                break;
            case __('Contract Signed'):
                $data = [
                    'name' => $situationType,
                    'sender' => 'NTP',
                    'description' => __('gui-situations.PROFILE-CONTRACT-SIGNED', [
                        'client' => $this->getAttribute('name')->getValue(),
                        'program' => $this->getActiveProgram()->getAttribute('program_name')->getValue()
                    ]),
                ];
                break;
            case __('Contract Date Sent'):
                $data = [
                    'name' => $situationType,
                    'sender' => 'NTP',
                    'description' => __('gui-situations.PROFILE-CONTRACT-DATE-SENT', [
                        'client' => $this->getAttribute('name')->getValue(),
                        'program' => $this->getActiveProgram()->getAttribute('program_name')->getValue()
                    ]),
                ];

                $situation = new Situation($data);
                $situation->addAttribute(self::selectOrCreateAttribute(['signed_at', "Datum potpisivanja ugovora", 'datetime', NULL, 1]));
                break;

        }

        if(isset($params)) {
            foreach($params as $key => $value) {
                $data[$key] = $value;
            }
        }

        if(count($data) > 0) {
            if($situation == null) {
                $situation = new Situation($data);
            } else {
                $situation->setData($data);
            }

            $this->addSituation($situation);
        }

    }

    public function getPrograms() {
        $programs = [];
        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Program') {
                $programs[] = ProgramFactory::resolve($instance->id);
            }
        }

        return collect($programs);
    }

    public function getActiveProgram() {
        if($this->instance->instances->count() == 0)
            return null;

        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Program') {
                return ProgramFactory::resolve($instance->id);
            }
        }
        return null;
    }

    public function addProgram($program) {
        $this->instance->instances()->save($program->instance);
        $this->instance->refresh();
        return $program;
    }

    public function removeProgram() {
        $this->getActiveProgram()->delete();
        $this->instance->instances->each(function($instance) {
            $instance->delete();
        });

        $this->instance->refresh();
    }







}
