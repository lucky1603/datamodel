<?php

namespace App\Business;

class Workflow
{
    public Program $program;
    public $phases;
    public $phraseIterator;


    public function __construct(Program $program=null)
    {
        $this->program = $program;
        $this->phases = $program != null ? $program->getPhases() : collect([]);
        $this->phraseIterator = $this->phases->getIterator();
    }

    // Inicijalizacija
    public function addPhase(int $index, Phase $phase) {
        $this->phases->put($index, $phase);
    }

    public function removePhase(Phase $phase) {
        $this->phases->forget($phase);
    }

    public function getPhase(int $index) {
        return $this->phases->get($index);
    }

    // Navigacija.
    public function nextPhase() {
        $this->phraseIterator->next();
        return $this->phraseIterator->current();
    }

    public function getCurrentPhase() {
        return $this->phraseIterator->current();
    }

    public function getCurrentIndex() {
        return $this->phraseIterator->key();
    }

    public function setCurrentIndex(int $index) {
        $this->phraseIterator->rewind();
        while($this->phraseIterator->valid()) {
            if($this->phraseIterator->key() == $index)
                break;
            $this->phraseIterator->next();
        }
    }

    public function rewind() {
        $this->phraseIterator->rewind();
    }

}
