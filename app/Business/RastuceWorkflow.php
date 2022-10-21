<?php

namespace App\Business;

class RastuceWorkflow extends Workflow
{
    protected function setAttributes($data = null) {
        if($data == null) {
            $data = [
                'program_type' => Program::$RASTUCE_KOMPANIJE
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
            $this->addPhase(1, new ProgramApplication(['program_type' => Program::$RASTUCE_KOMPANIJE]));
            $this->addPhase(2, new AppFormEvaluation());
            $this->addPhase(3, new Contract());
        }
    }
}
