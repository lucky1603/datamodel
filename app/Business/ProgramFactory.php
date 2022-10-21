<?php

namespace App\Business;

class ProgramFactory
{
    public static function resolve($instanceId, $initWorkflow = false) {
        $model = new BusinessModel(['instance_id' => $instanceId]);
        if($model->instance == NULL)
            return null;

        $programType = $model->getValue('program_type');
        switch ($programType) {
            case Program::$INKUBACIJA_BITF:
                return new IncubationProgram(['instance_id' => $instanceId, 'init_workflow' => $initWorkflow]);
            case Program::$RAISING_STARTS:
                return new RaisingStartsProgram(['instance_id' => $instanceId, 'init_workflow' => $initWorkflow]);
            case Program::$RASTUCE_KOMPANIJE:
                return new RastuceProgram(['instance_id' => $instanceId, 'init_workflow' => $initWorkflow]);
            default:
                return null;
        }
    }

    public static function create($programType, $data) {
        switch ($programType) {
            case Program::$RAISING_STARTS:
                return new RaisingStartsProgram($data);
            case Program::$INKUBACIJA_BITF:
                return new IncubationProgram($data);
            case Program::$RASTUCE_KOMPANIJE:
                return new RastuceProgram($data);
            default:
                return null;
        }
    }
}
