<?php

namespace App\Business;

use App\Entity;
use App\Instance;
use Illuminate\Support\Collection;

class Menthor extends SituationsModel
{

    protected function getEntity()
    {
        $entity = Entity::where('name', 'Menthor')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Menthor', 'description' => 'Mentor organizacije']);
            $attributes = self::getAttributesDefinition();
            foreach ($attributes as $attribute) {
                $entity->addAttribute($attribute);
            }
        }

        return $entity;
    }

    /**
     * Sets the default attributes values.
     * @param null $data
     */
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'name' => null,
                'company' => null,
                'address' => null,
                'email' => null,
                'phone' => null,
                'photo' => [
                    'filelink' => '',
                    'filename' => ''
                ],
                'business_branch' => [],
                'remark' => null
            ];
        }

        $this->setData($data);
    }

    /**
     * Entitles a menthor to the program.
     * @param $programId
     * @return Program
     */
    public function addProgram($programId)
    {
        $this->instance->instances()->save(Instance::find($programId));
        $this->instance->refresh();
    }

    /**
     * Detaches the program from the menthor.
     * @param $programId
     */
    public function removeProgram($programId) {
        $this->instance->instances()->detach($programId);
        $this->instance->refresh();
    }

    /**
     * Get all of the programs, the menthor is entitled to.
     * @return mixed
     */
    public function getPrograms()
    {
        return $this->instance->instances->filter(function($instance) {
             if($instance->entity->name == 'Program')
                 return true;
        })->map(function($instance) {
            return new Program(0, ['instance_id' => $instance->id]);
        });
    }

    /**
     * Adds the session object to menthor.
     * @param Session $session
     * @return Session
     */
    public function addSession(Session $session): Session
    {
        $this->instance->instances()->save($session->instance);
        $this->instance->refresh();
        return $session;
    }

    /**
     * Removes the session object from menthor.
     * @param Session $session
     */
    public function removeSession(Session $session) {
        $this->instance->instances()->detach($session->instance->id);
        $this->instance->refresh();
    }

    /**
     * Gets the seesions for this menthor.
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
     * Get attributes definition for this object type.
     */
    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        // ime
        $attributes->add(self::selectOrCreateAttribute(['name', __('Name'), 'varchar', NULL, 1]));
        // Firma
        $attributes->add(self::selectOrCreateAttribute(['company', __('Company'), 'varchar', NULL, 2]));

        // Email
        $attributes->add(self::selectOrCreateAttribute(['email', __('Email'), 'varchar' , ['ui' => 'email'], 3]));
        // Telefon
        $attributes->add(self::selectOrCreateAttribute(['phone', __('Phone'), 'varchar', NULL, 4]));
        // Adresa
        $attributes->add(self::selectOrCreateAttribute(['address', __('Address'), 'varchar', NULL, 5]));
        // Slika
        $attributes->add(self::selectOrCreateAttribute(['photo', __('Photo'), 'file', NULL, 6]));

        // Specijalnosti
        $specialities = self::selectOrCreateAttribute(['specialities', __('Specialities'), 'select', 'multiselect', 7]);
        if(count($specialities->getOptions()) == 0) {
            $specialities->addOption(['value' => 1, 'text' => __('gui-select.BB-IOT')]);
            $specialities->addOption(['value' => 2, 'text' => __('gui-select.BB-EnEff')]);
            $specialities->addOption(['value' => 3, 'text' => __('gui-select.BB-AI')]);
            $specialities->addOption(['value' => 4, 'text' => __('gui-select.BB-NewMat')]);
            $specialities->addOption(['value' => 5, 'text' => __('gui-select.BB-TechSport')]);
            $specialities->addOption(['value' => 6, 'text' => __('gui-select.BB-vEcoTrans')]);
            $specialities->addOption(['value' => 7, 'text' => __('gui-select.BB-RoboAuto')]);
            $specialities->addOption(['value' => 8, 'text' => __('gui-select.BB-Tourism')]);
            $specialities->addOption(['value' => 9, 'text' => __('gui-select.BB-Education')]);
            $specialities->addOption(['value' => 10,'text' => __('gui-select.BB-MediaGaming')]);
            $specialities->addOption(['value' => 11, 'text' => __('gui-select.BB-MedTech')]);
            $specialities->addOption(['value' => 12, 'text' => __('gui-select.BB-Other')]);
        }
        $attributes->add($specialities);

        $menthorType = self::selectOrCreateAttribute(['menthor-type', __("Menthor Type"), 'select', NULL, 8]);
        if(count($menthorType->getOptions()) == 0) {
            $menthorType->addOption(['value' => 1, 'text' => __('Business Menthor')]);
            $menthorType->addOption(['value' => 2, 'text' => __('Tech Menthor')]);
        }
        $attributes->add($menthorType);

        // Primedbe (ostalo)
        $attributes->add(self::selectOrCreateAttribute(['remark', __('Remark'), 'text', NULL, 8]));

        return $attributes;

    }

}
