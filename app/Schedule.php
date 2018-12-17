<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'customer_id', 'from_user_id', 'to_user_id', 'description', 'initial_date', 'final_date'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'initial_date', 'final_date'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
