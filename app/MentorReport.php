<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MentorReport extends Model
{
    protected $guarded = [];

    public function program_instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function mentor_instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
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
}
