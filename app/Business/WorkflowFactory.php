<?php

namespace App\Business;

class WorkflowFactory
{
    public static function resolve($instanceId) {
        $workflow = new Workflow(['instance_id' => $instanceId]);
        switch($workflow->getValue('program_type'))
        {
            case Program::$RAISING_STARTS:
                return new RaisingStartsWorkflow(['instance_id' => $instanceId]);
            case Program::$INKUBACIJA_BITF:
                return new IncubationWorkflow(['instance_id' => $instanceId]);
            default:
                return null;
        }
    }
}
