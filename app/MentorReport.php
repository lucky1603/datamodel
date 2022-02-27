<?php

namespace App;

use App\Business\Mentor;
use App\Business\Program;
use App\Business\ProgramFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MentorReport extends Model
{
    protected $guarded = [];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function file_groups(): BelongsToMany
    {
        return $this->belongsToMany(FileGroup::class);
    }

    public function attachProgram(Program $program) {
        $this->program()->associate($program->getId());
    }

    public function detachProgram() {
        $this->program()->dissociate();
    }

    public function programBO() {
        return ProgramFactory::resolve($this->program->id);
    }

    public function mentorBO() {
        return Mentor::find($this->mentor->id);
    }

    public function attachMentor(Mentor $mentor) {
        $this->mentor()->associate($mentor->getId());
        $this->refresh();
    }

    public function detachMentor() {
        $this->mentor()->dissociate();
        $this->refresh();
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
