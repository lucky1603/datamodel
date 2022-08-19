<?php

namespace App\Business;

use App\Entity;
use App\Instance;
use App\MentorReport;
use Illuminate\Support\Collection;

class Mentor extends SituationsModel
{

    protected function getEntity()
    {
        $entity = Entity::where('name', 'Mentor')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Mentor', 'description' => 'Mentor organizacije']);
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
     * Entitles a mentor to the program.
     * @param $program
     */
    public function addProgram($program)
    {
        $this->instance->instances()->save($program->instance);
        $this->instance->refresh();
    }

    /**
     * Detaches the program from the mentor.
     * @param $program
     */
    public function removeProgram(Program $program) {

        // First remove the program sessions
        $this->removeSessionsForProgram($program);

        // Remove reports connected to this mentor and program.
        $this->removeReportsForProgram($program);

        // Detach program and refresh.
        $this->instance->instances()->detach($program->instance->id);
        $this->instance->refresh();
    }

    /**
     * Removes all programs from a mentor.
     * By removing of the program, all attached sessions
     * and reports will be deleted too.
     */
    public function removeAllPrograms() {
        $this->getPrograms()->each(function($program) {

            $this->removeProgram($program);
        });
    }

    /**
     * Get all of the programs, the mentor is entitled to.
     * @return mixed
     */
    public function getPrograms()
    {
        return $this->instance->instances->filter(function($instance) {
             if($instance->entity->name == 'Program')
                 return true;
        })->map(function($instance) {
            return ProgramFactory::resolve($instance->id);
        });
    }

    /**
     * Adds the session object to mentor.
     * @param Session $session
     */
    public function addSession($session)
    {
        $this->instance->instances()->save($session->instance);
        $this->instance->refresh();
    }

    /**
     * Removes the session object from mentor.
     * @param Session $session
     */
    public function removeSession($session) {
        // First remove the session from the mentor.
        $program = $session->getProgram();
        $program->removeSession($session);

        // Now remove it from here.
        $this->instance->instances()->detach($session->instance->id);
        $this->instance->refresh();

        // and delete it.
        $session->delete();
    }


    /**
     * Remove all sessions for one program.
     * @param Program $program
     */
    public function removeSessionsForProgram(Program $program) {
        // Check if this program belongs to this mentor.
        $sessions = $this->getSessionsForProgram($program);
        foreach ($sessions as $session) {
            $this->removeSession($session);
        }
    }

    public function removeReportsForProgram(Program $program) {
        $reports = $this->getReportsForProgram($program->getId());
        $reports->each(function($report) {
            $report->delete();
        });
    }

    /**
     * Deletes the mentor.
     */
    public function delete()
    {
        $this->removeAllPrograms();
        parent::delete();
    }

    /**
     * Gets the seesions for this mentor.
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
     * Returns the session collection for the given program.
     * @param Program $program
     * @return mixed
     */
    public function getSessionsForProgram(Program $program) {
        return $this->getSessions()->filter(function($session) use($program) {
            return $session->getProgram()->getId() == $program->getId();
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

        $mentorType = self::selectOrCreateAttribute(['mentor-type', __("Mentor Type"), 'select', NULL, 8]);
        if(count($mentorType->getOptions()) == 0) {
            $mentorType->addOption(['value' => 1, 'text' => __('Business')]);
            $mentorType->addOption(['value' => 2, 'text' => __('Tech')]);
            $mentorType->addOption(['value' => 3, 'text' => __('Specialist')]);
        }
        $attributes->add($mentorType);

        // Primedbe (ostalo)
        $attributes->add(self::selectOrCreateAttribute(['remark', __('Remark'), 'text', NULL, 8]));

        return $attributes;

    }

    /**
     * Get mentor reports for this program and mentor.
     * @param Program $program
     * @return mixed
     */
    public function getReportsForProgram($programId) {
        $mentorId = $this->getId();
        return MentorReport::all()->filter(function($report) use ($programId, $mentorId) {
            return $report->program_id == $programId && $report->mentor_id == $mentorId;
        });

    }

}
