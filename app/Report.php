<?php

namespace App;

use App\Business\ProgramFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Report extends Model
{
    protected $guarded = [];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class);
    }

    public function addAttachment(Attachment $attachment)
    {

        $this->attachments()->attach($attachment);
        $this->refresh();
    }

    public function removeAttachment(Attachment $attachment) {
        $attachment->delete();
        $this->refresh();
    }

    public function removeAllAttachments() {
        foreach($this->attachments as $attachment) {
            $attachment->delete();
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
