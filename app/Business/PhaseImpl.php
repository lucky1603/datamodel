<?php

namespace App\Business;

class PhaseImpl extends BusinessModel implements Phase
{

    public function getDisplayName()
    {
        // TODO: Implement getDisplayName() method.
    }

    public function getDisplayId()
    {
        // TODO: Implement getDisplayId() method.
    }

    public function getDisplayForm()
    {
        // TODO: Implement getDisplayForm() method.
    }

    public function getAttributesData()
    {
        // TODO: Implement getAttributesData() method.
    }

    public function getStatusValue()
    {
        // TODO: Implement getStatusValue() method.
    }

    public function setStatusValue($value)
    {
        // TODO: Implement setStatusValue() method.
    }

    public function requiresEntryEmail()
    {
        // TODO: Implement requiresEntryEmail() method.
    }

    public function getEntryEmailTemplate()
    {
        // TODO: Implement getEntryEmailTemplate() method.
    }

    public function requiresExitEmail()
    {
        // TODO: Implement requiresExitEmail() method.
    }

    public function getExitEmailTemplate()
    {
        // TODO: Implement getExitEmailTemplate() method.
    }

    public function requiresEntrySituation()
    {
        // TODO: Implement requiresEntrySituation() method.
    }

    public function getEntrySituation()
    {
        // TODO: Implement getEntrySituation() method.
    }

    public function requiresExitSituation()
    {
        // TODO: Implement requiresExitSituation() method.
    }

    public function getExitSituation()
    {
        // TODO: Implement getExitSituation() method.
    }

    public function getWorkflow() {
        $instance = $this->instance->parentInstances->filter(function($instance) {
            if($instance->entity->name == 'Workflow')
                return true;
            return false;
        })->first();

        if($instance == null)
            return null;

        return WorkflowFactory::resolve($instance->id);
    }

    public function isVisibleInHistory(): bool
    {
        return true;
    }
}
