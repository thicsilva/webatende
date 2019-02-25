<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = ['description'];

    public function serviceOrders()
    {
        return $this->belongsToMany(ServiceOrder::class);
    }
}
