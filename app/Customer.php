<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'fantasy_name', 'doc_number', 'city', 'phone', 'email', 'has_contract', 'has_restriction', 'restriction_annotation',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function calls()
    {
        return $this->hasMany(Call::class);
    }

    public  function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delete()
    {
        $this->calls()->delete();
        parent::delete();
    }

    public function setDocNumberAttribute($value){
        $this->attributes['doc_number'] = preg_replace("/\D/",'', $value);
    }
}
