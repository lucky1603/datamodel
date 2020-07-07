<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    protected $fillable = ['attribute_id','value', 'text'];

    public function attribute() {
        return $this->belongsTo(Attribute::class);
    }
}
