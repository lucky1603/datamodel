<?php

namespace App\Business;

class ProgramFactory
{
    public static function resolve($instanceId) {
        $model = new BusinessModel(['instance_id' => $instanceId]);
        if($model->instance == NULL)
            return null;

        $programType = $model->getValue('program_type');
        switch ($programType) {
            case Program::$INKUBACIJA_BITF:
                return new IncubationProgram(['instance_id' => $instanceId]);
            case Program::$RAISING_STARTS:
                return new RaisingStartsProgram(['instance_id' => $instanceId]);
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
            default:
                return null;
        }
    }
}
