<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class File extends Model
{
    protected $guarded = [];

    public function file_groups(): BelongsToMany
    {
        return $this->belongsToMany();
    }
}
