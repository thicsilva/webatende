<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Situation extends Model
{
    protected $fillable = ['description', 'color'];

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }
}
