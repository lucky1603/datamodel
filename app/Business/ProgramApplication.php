<?php

namespace App\Business;

use App\Entity;
use Illuminate\Support\Collection;

class ProgramApplication extends PhaseImpl
{
    private int $status = -1;

    protected function getEntity()
    {
        $entity = Entity::where('name', 'ProgramApplication')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'ProgramApplication', 'description' => __('Prijava na program')]);
        }

        return $entity;
    }

    public function getDisplayName(): string
    {
        return 'Prijava na program';
    }

    public function getDisplayId(): string
    {
        return '#application';
    }

    public function getDisplayForm(): string
    {
        return 'profiles.partials._show_profile_data';
    }

    public function getAttributesData(): array
    {
        return [];
    }

    public function getStatusValue(): int
    {
        return $this->status;
    }

    public function setStatusValue($value)
    {
        $this->status = $value;
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['program_type', __('Program Type'), 'integer', NULL, 1]));

        return $attributes;
    }


}
