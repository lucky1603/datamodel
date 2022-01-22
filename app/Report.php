<?php

namespace App;

use App\Business\ProgramFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $guarded = [];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function getProgram() {
        if($this->instance != null) {
            return ProgramFactory::resolve($this->instance->id);
        }

        return null;
    }

    public function getProfile(): ?Business\Profile
    {
        $program = $this->getProgram();
        if($program != null) {
            return $program->getProfile();
        }

        return null;
    }
}
