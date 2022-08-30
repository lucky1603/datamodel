<?php

namespace App;

use App\Business\ProgramFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Report extends Model
{
    public static int $SCHEDULED = 0;
    public static int $WARNING = 1;
    public static int $SENT = 2;
    public static int $LATE = 3;
    public static int $APPROVED = 4;
    public static int $REJECTED = 5;


    protected $guarded = [];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function company_stat() {
        return $this->belongsTo(CompanyStat::class);
    }

    public function file_groups(): BelongsToMany
    {
        return $this->belongsToMany(FileGroup::class);
    }

    public function addFileGroup(FileGroup $fileGroup)
    {
        $this->file_groups()->attach($fileGroup->id);
        $this->refresh();
    }

    public function removeFileGroup(FileGroup $fileGroup) {
        $this->file_groups()->detach($fileGroup->id);
        $fileGroup->delete();
        $this->refresh();
    }

    public function removeAllFileGroups() {
        $ids = [];
        foreach($this->file_groups as $file_group) {
            $ids[] = $file_group->id;
        }

        $this->file_groups()->detach();
        foreach($ids as $id) {
            $fileGroup = FileGroup::find($id);
            $fileGroup->delete();
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
