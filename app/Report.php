<?php

namespace App;

use App\Business\ProgramFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    public static int $SCHEDULED = 0;
    public static int $WARNING = 1;
    public static int $SENT = 2;
    public static int $LATE = 3;

    protected $guarded = [];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function file_groups(): HasMany
    {
        return $this->hasMany(FileGroup::class);
    }

    public function addFileGroup(FileGroup $fileGroup)
    {
        $this->file_groups()->save($fileGroup);
        $this->refresh();
    }

    public function removeFileGroup(FileGroup $fileGroup) {
        $fileGroup->delete();
        $this->refresh();
    }

    public function removeAllFileGroups() {
        foreach($this->file_groups as $file_group) {
            $file_group->delete();
        }

        $this->refresh();
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
