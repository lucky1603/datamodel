<?php

namespace App\Business;

class IncubationWorkflow extends Workflow
{
    protected function setAttributes($data = null)
    {
        if($data == null) {
            $data = [
                'program_type' => Program::$INKUBACIJA_BITF
            ];
        }

        parent::setAttributes($data);
    }

    protected function initPhases()
    {
        parent::initPhases();

        if($this->instance->instances->count() > 0) {
            $counter = 0;
            foreach($this->instance->instances as $instance) {
                $phase = PhaseFactory::resolve($instance->id);
                $phase->setStatusValue(++$counter);
                $this->phases->put($counter, $phase);
            }
        } else {
            $this->addPhase(1, new ProgramApplication(['program_type' => Program::$INKUBACIJA_BITF]));
            $this->addPhase(2, new Preselection());
            $this->addPhase(3, new Selection());
            $this->addPhase(4, new Contract());
        }
    }
}
