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

    protected function getActiveServiceOrdersAttribute($value)
    {
        return $value ?? $this->activeServiceOrders = $this->serviceOrders()->where('status', 1)->count();
    }
}
