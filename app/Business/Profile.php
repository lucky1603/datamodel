<?php


namespace App\Business;


use App\Attribute;
use App\AttributeGroup;
use App\Entity;
use App\Instance;
use App\ProfileCache;
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
                'profile_logo' => [
                    'filename' => '',
                    'filelink' => ''
                ],
                'profile_background' => [
                    'filename' => '',
                    'filelink' => ''
                ]
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
            $business_branch->addOption(['value' => 5, 'text' => __('gui-select.BB-Civic')]);
            $business_branch->addOption(['value' => 6, 'text' => __('gui-select.BB-TechSport')]);
            $business_branch->addOption(['value' => 7, 'text' => __('gui-select.BB-Finance')]);
            $business_branch->addOption(['value' => 8, 'text' => __('gui-select.BB-Marketing')]);
            $business_branch->addOption(['value' => 9, 'text' => __('gui-select.BB-EcoTrans')]);
            $business_branch->addOption(['value' => 10, 'text' => __('gui-select.BB-RoboAuto')]);
            $business_branch->addOption(['value' => 11, 'text' => __('gui-select.BB-Tourism')]);
            $business_branch->addOption(['value' => 12, 'text' => __('gui-select.BB-Education')]);
            $business_branch->addOption(['value' => 13,'text' => __('gui-select.BB-MediaGaming')]);
            $business_branch->addOption(['value' => 14, 'text' => __('gui-select.BB-MedTech')]);
            $business_branch->addOption(['value' => 15, 'text' => __('gui-select.BB-Agriculture')]);
            $business_branch->addOption(['value' => 16, 'text' => __('gui-select.BB-Other')]);
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

        $attributes[] = self::selectOrCreateAttribute(['profile_logo', __('Profile Logo'), 'file', NULL, 15]);
        $attributes[] = self::selectOrCreateAttribute(['profile_background', __('Profile Background'), 'file', NULL, 16]);
        $attributes[] = self::selectOrCreateAttribute(['profile_webpage', __('Profile Webpage'), 'varchar', NULL, 17]);
        $state = self::selectOrCreateAttribute(['profile_state', __('Profile State'), 'select', NULL, 18]);
        if(count($state->getOptions()) == 0) {
            $state->addOption(['value' => 1, 'text' => __('gui-select.PROFSTATE-Interested')]);
            $state->addOption(['value' => 2, 'text' => __('gui-select.PROFSTATE-Application')]);
            $state->addOption(['value' => 3, 'text' => __('gui-select.PROFSTATE-Sent')]);
            $state->addOption(['value' => 4, 'text' => __('gui-select.PROFSTATE-Phase1')]);
            $state->addOption(['value' => 5, 'text' => __('gui-select.PROFSTATE-DemoDay')]);
            $state->addOption(['value' => 6, 'text' => __('gui-select.PROFSTATE-Contract')]);
            $state->addOption(['value' => 7, 'text' => __('gui-select.PROFSTATE-InProgram')]);
            $state->addOption(['value' => 8, 'text' => __('gui-select.PROFSTATE-Rejected')]);
        }
        $attributes[] = $state;

        $ntp = self::selectOrCreateAttribute(['ntp', 'NTP koji daje podršku', 'select', NULL, 4]);
        if(count($ntp->getOptions()) == 0) {
            $ntp->addOption(['value' => 1, 'text' => 'Naučno-tehnološki park Beograd']);
            $ntp->addOption(['value' => 2, 'text' => 'Naučno-tehnološki park Niš']);
            $ntp->addOption(['value' => 3, 'text' => 'Naučno-tehnološki park Čačak']);
        }
        $attributes[] = $ntp;

        $membership_type = self::selectOrCreateAttribute(['membership_type', __('Tip članstva'), 'select', NULL, 19]);
        if(count($membership_type->getOptions()) == 0) {
            $membership_type->addOption(['value' => 0, 'text' => 'Nije član']);
            $membership_type->addOption(['value' => 1, 'text' => 'Punopravni član']);
            $membership_type->addOption(['value' => 2, 'text' => 'Virtuelni član']);
            $membership_type->addOption(['value' => 3, 'text' => 'Alumni']);
        }
        $attributes[] = $membership_type;

        $ntp = self::selectOrCreateAttribute(['ntp', 'NTP koji daje podršku', 'select', NULL, 20]);
        if(count($ntp->getOptions()) == 0) {
            $ntp->addOption(['value' => 1, 'text' => 'Naučno-tehnološki park Beograd']);
            $ntp->addOption(['value' => 2, 'text' => 'Naučno-tehnološki park Niš']);
            $ntp->addOption(['value' => 3, 'text' => 'Naučno-tehnološki park Čačak']);
        }
        $attributes[] = $ntp;

        $program_name = self::selectOrCreateAttribute(['program_name', __('Program Name'), 'varchar', NULL, 21]);
        $attributes[] = $program_name;

        $ag_cache = AttributeGroup::where('name', 'profile_cache')->first();
        if($ag_cache == null) {
            $ag_cache = AttributeGroup::create([
                'name' => 'profile_cache',
                'label' => 'Profile Cached Attributes',
                10
            ]);
        }

        $ag_cache->addAttribute($ntp);
        $ag_cache->addAttribute($program_name);

        return $attributes;
    }

    public static function makeCache() {
        DB::table('profile_caches')->delete();

        Profile::find()->each(function($profile) {
            $is_company = $profile->getValue('is_company');
            $program = $profile->getActiveProgram();
            $logo = $profile->getValue('profile_logo');
            if($logo == null || $logo == ['filename' => '', 'filelink' => '']) {
                $logo = asset('images/custom/nophoto2.png', false);
            } else {
                $logo = $logo['filelink'];
            }

            DB::table('profile_caches')->insert([
                'profile_id' => $profile->getId(),
                'name' => $profile->getValue('name'),
                'logo' => $logo,
                'membership_type' => $profile->getValue('membership_type'),
                'membership_type_text' => $profile->getText('membership_type'),
                'ntp' => $profile->getValue('ntp'),
                'ntp_text' => $profile->getText('ntp'),
                'profile_state' => $profile->getValue('profile_state'),
                'profile_state_text' => $profile->getText('profile_state'),
                'is_company' => $is_company,
                'is_company_text' => $is_company == true ? "Kompanija" : "Startap",
                'program_name' => $program->getValue('program_name'),
                'contact_person_name' => $profile->getValue('contact_person'),
                'contact_person_email' => $profile->getValue('contact_email')
            ]) ;
        });
    }

    public static function addAdditionalAttributes() {
        $membership_type = self::selectOrCreateAttribute(['membership_type', __('Tip članstva'), 'select', NULL, 19]);
        if(count($membership_type->getOptions()) == 0) {
            $membership_type->addOption(['value' => 0, 'text' => 'Nije član']);
            $membership_type->addOption(['value' => 1, 'text' => 'Punopravni član']);
            $membership_type->addOption(['value' => 2, 'text' => 'Virtuelni član']);
            $membership_type->addOption(['value' => 3, 'text' => 'Alumni']);
        }
        Profile::addOverallAttribute($membership_type, 1);

        $ntp = self::selectOrCreateAttribute(['ntp', 'NTP koji daje podršku', 'select', NULL, 20]);
        if(count($ntp->getOptions()) == 0) {
            $ntp->addOption(['value' => 1, 'text' => 'Naučno-tehnološki park Beograd']);
            $ntp->addOption(['value' => 2, 'text' => 'Naučno-tehnološki park Niš']);
            $ntp->addOption(['value' => 3, 'text' => 'Naučno-tehnološki park Čačak']);
        }

        // Add cache attributes.
        Profile::addOverallAttribute($ntp, 1);
        $program_name = self::selectOrCreateAttribute(['program_name', __('Program Name'), 'varchar', NULL, 21]);
        Profile::addOverallAttribute($program_name, '');
        Profile::find()->each(function($profile) {
            $program = $profile->getActiveProgram();
            $profile->setValue('ntp', $program->getValue('ntp'));
            $profile->setValue('program_name', $program->getValue('program_name'));
        });

        $cache_attributes = self::selectOrCreateAttribute(['attributes_cached', __('Attributes Cached'), 'bool', NULL, 22]);
        Profile::addOverallAttribute($cache_attributes, false);

        $ag_cache = AttributeGroup::where('name', 'profile_cache')->first();
        if($ag_cache == null) {
            $ag_cache = AttributeGroup::create([
                'name' => 'profile_cache',
                'label' => 'Profile Cached Attributes',
                'sort_order' => 10
            ]);
        }

        $ag_cache->addAttribute($ntp);
        $ag_cache->addAttribute($program_name);
        $ag_cache->addAttribute($cache_attributes);
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

    public function getActiveProgram($initWorkflow = false) {
        if($this->instance->instances->count() == 0)
            return null;

        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Program') {
                return ProgramFactory::resolve($instance->id, $initWorkflow);
            }
        }
        return null;
    }

    public function getActiveProgramInstanceId() {
        if($this->instance->instances->count() == 0)
            return null;

        foreach($this->instance->instances as $instance) {
            if($instance->entity->name === 'Program') {
                return $instance->id;
            }
        }
        return 0;
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

    public function delete()
    {
        $this->instance->instances->each(function($instance) {
            $instance->delete();
        });

        $this->getUsers()->each(function($user) {
            if($user->profiles()->count() == 1) {
                $user->delete();
            }
        });

        parent::delete(); // TODO: Change the autogenerated stub
    }

    public function updateState() {
        $profileStatus = $this->getValue('profile_status');
        $programStatus = $this->getActiveProgram() != null ? $this->getActiveProgram()->getStatus() : 0;
        $profileCache = ProfileCache::where('profile_id', $this->getId())->first();
        $attribute = $this->getAttribute('profile_state');

        if(in_array($profileStatus, [1,2])) {
            $value = 1;
        } else if($profileStatus == 3 && $programStatus == 1) {
            $value = 2;
        } else if($profileStatus == 3 && $programStatus == 2) {
            $value = 3;
        } else if($profileStatus == 3 && in_array($programStatus, [3,4])) {
            $value = 4;
        } else if($profileStatus == 3 && $programStatus == 5) {
            $value = 5;
        } else if($profileStatus == 4 ) {
            $value = 6;
        } else {
            $value = 7;
        }

        $this->setValue('profile_state', $value);
        $profileCache->profile_state = $value;
        $profileCache->profile_state_text = $attribute->getText();
        $profileCache->save();

    }

    public static function setStateAttribute() {

        $attribute = Attribute::where('name', 'profile_state')->first();
        if($attribute != null) {
            self::removeOverallAttribute($attribute);
        }

        $state = self::selectOrCreateAttribute(['profile_state', __('Profile State'), 'select', NULL, 18]);
        if(count($state->getOptions()) == 0) {
            $state->addOption(['value' => 1, 'text' => __('gui-select.PROFSTATE-Interested')]);
            $state->addOption(['value' => 2, 'text' => __('gui-select.PROFSTATE-Application')]);
            $state->addOption(['value' => 3, 'text' => __('gui-select.PROFSTATE-Sent')]);
            $state->addOption(['value' => 4, 'text' => __('gui-select.PROFSTATE-Selection')]);
            $state->addOption(['value' => 5, 'text' => __('gui-select.PROFSTATE-Contract')]);
            $state->addOption(['value' => 6, 'text' => __('gui-select.PROFSTATE-InProgram')]);
            $state->addOption(['value' => 7, 'text' => __('gui-select.PROFSTATE-Rejected')]);
        }

        static::addOverallAttribute($state);

        static::find()->each(function($profile) {
            $profile->updateState();
        });
    }


}
