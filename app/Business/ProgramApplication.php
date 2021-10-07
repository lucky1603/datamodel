<?php

namespace App\Business;

class ProgramApplication implements Phase
{

    public Program $program;

    public function __construct($programId)
    {
        $this->program = new Program(0, ['instance_id' => $programId]);
    }

    public function getId()
    {
        return $this->program->getId();
    }

    public function getDisplayName(): string
    {
        return 'Prijava na program';
    }

    public function getDisplayId(): string
    {
        return '#application';
    }

    public function getUI(): string
    {
        return 'profiles.partials._show_profile_data';
    }

    public function getAttributesData(): array
    {
        return [];
    }

    public function getStatusValue()
    {
        // TODO: Implement getStatusValue() method.
    }

    public function setStatusValue($value)
    {
        // TODO: Implement setStatusValue() method.
    }
}
