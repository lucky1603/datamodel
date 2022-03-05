<?php

namespace App\Business;

use Illuminate\Mail\Mailable;

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

    public function requiresEntryEmail(): bool
    {
        // TODO: Implement requiresEntryEmail() method.
        return false;
    }

    public function getEntryEmailTemplate(): ?Mailable
    {
        // TODO: Implement getEntryEmailTemplate() method.
        return null;
    }

    public function requiresExitEmail(): bool
    {
        // TODO: Implement requiresExitEmail() method.
        return false;
    }

    public function getExitEmailTemplate(): ?Mailable
    {
        // TODO: Implement getExitEmailTemplate() method.
        return null;
    }

    public function requiresEntrySituation(): bool
    {
        // TODO: Implement requiresEntrySituation() method.
        return false;
    }

    public function getEntrySituation() : ?Situation
    {
        // TODO: Implement getEntrySituation() method.
        return null;
    }

    public function requiresExitSituation(): bool
    {
        // TODO: Implement requiresExitSituation() method.
        return false;
    }

    public function getExitSituation() : ?Situation
    {
        // TODO: Implement getExitSituation() method.
        return null;
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

    public function isValid(): bool
    {
        return true;
    }

    public function validateData(Array $data): array
    {
        return [
            'code' => 0,
            'message' => 'Podaci validni'
        ];
    }

    public function getClientDisplayForm()
    {
        return null;
    }
}
