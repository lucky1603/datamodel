<?php

namespace App\Business;

class PhaseFactory
{
    public static function resolve($instanceId) {
        $model = new BusinessModel(['instance_id' => $instanceId]);
        if($model->instance == null)
            return null;

        switch($model->instance->entity->name) {
            case "Preselection":
                return new Preselection(['instance_id' => $instanceId]);
            case "Selection":
                return new Selection(['instance_id' => $instanceId]);
            case 'DemoDay':
                return new DemoDay(['instance_id' => $instanceId]);
            case 'Contract':
                return new Contract(['instance_id' => $instanceId]);
            case 'ProgramApplication':
                return new ProgramApplication(['instance_id' => $instanceId]);
            case 'AppFormEvaluation':
                return new AppFormEvaluation((['instance_id' => $instanceId]));
            default:
                return new Faza1(['instance_id' => $instanceId]);
        }

    }
}
