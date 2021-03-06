<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['model', 'serial', 'type_id'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

