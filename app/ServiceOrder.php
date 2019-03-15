<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = ['customer_id', 'contact', 'equipment_id',
    'serial', 'entrance_movement_id', 'entrance_date', 'budget',
    'factory', 'documents', 'fault', 'exit_date', 'exit_movement_id',
    'status', 'user_id' ,'situation_id', 'os_number'];

    protected $dates = ['created_at', 'updated_at', 'entrance_date', 'exit_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function entranceMovement()
    {
        return $this->belongsTo(Movement::class, 'entrance_movement_id');
    }

    public function exitMovement()
    {
        return $this->belongsTo(Movement::class, 'exit_movement_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(Accessory::class);
    }

    public function situation()
    {
        return $this->belongsTo(Situation::class);
    }
}
