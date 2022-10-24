<?php

namespace App\Business;

use App\Entity;
use App\Instance;
use App\Business\BusinessModel;
use Illuminate\Support\Collection;

class Workflow extends BusinessModel
{
    public Program $program;
    public Collection $phases;
    public \ArrayIterator $phaseIterator;

    public function __construct(array $data = null)
    {
        parent::__construct($data);

        $this->initPhases();
        $this->phaseIterator = $this->phases->getIterator();
    }

    protected function getEntity()
    {
        $entity = Entity::where('name', 'Workflow')->first();
        if($entity == null) {
            $entity = Entity::create(['name' => 'Workflow', 'description' => __('Workflow')]);
        }

        return $entity;
    }

    public function getProgram() {
        return $this->instance->parentInstances->filter(function ($instance) {
            if($instance->entity->name == 'Program')
                return true;
            return false;
        })->map(function($instance) {
            return ProgramFactory::resolve($instance->id);
        })->first();
    }

    // Initializes.
    public function addPhase(int $index, Phase $phase) {
        $this->instance->instances()->attach($phase->getId());
        $phase->setStatusValue($index);
        $this->phases->put($index, $phase);
    }

    public function removePhase(Phase $phase) {
        $phaseInstance = $this->instance->instances->where('id', $phase->getId());
        $this->instance->instances()->detach($phase->getId());
        $this->phases->forget($phase);
        $phaseInstance->delete();

    }

    public function removeAllPhases() {
        foreach($this->instance->instances as $instance) {
            $this->instance->instances()->detach($instance->id);
            $instance->delete();
        }

        $this->instance->save();
    }

    public function getPhase(int $index) : ?Phase {
        return $this->phases->get($index);
    }

    public function getPhases() {
        return $this->instance->instances->map(function($instance) {
            return PhaseFactory::resolve($instance->id);
        });
    }

    // Navigation.
    public function nextPhase() : ?Phase {
        $this->phaseIterator->next();
        return $this->phaseIterator->current();
    }

    public function getCurrentPhase() : ?Phase {
        return $this->phaseIterator->current();
    }

    public function getCurrentIndex() : int {
        return $this->phaseIterator->key();
    }

    public function setCurrentIndex(int $index) {
        $this->phaseIterator->rewind();
        while($this->phaseIterator->valid()) {
            if($this->phaseIterator->key() == $index)
                break;
            $this->phaseIterator->next();
        }
    }

    public function rewind() {
        $this->phaseIterator->rewind();
    }

    public function isLastStep(): bool
    {
        if($this->phases->count() == $this->getCurrentIndex())
            return true;
        return false;
    }

    protected function initPhases(){
        $this->phases = collect([]);
    }

    public static function getAttributesDefinition(): Collection
    {
        $attributes = collect([]);

        $attributes->add(self::selectOrCreateAttribute(['program_type', __('Program Type'), 'integer', NULL, 1]));

        return $attributes;
    }

}
