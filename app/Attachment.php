<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attachment extends Model
{
    protected $guarded = [];

    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class);
    }
}
