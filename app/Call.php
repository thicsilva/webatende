<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = [
        'customer_id', 'from_user_id', 'to_user_id', 'contact', 'subject', 'status'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function delete()
    {
        $this->comments()->delete();
        $this->budgets()->delete();
        parent::delete();
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
