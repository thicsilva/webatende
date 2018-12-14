<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id', 'call_id', 'comment',
    ];

    protected $dates = [
        'created_at', 'updated_at',
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
