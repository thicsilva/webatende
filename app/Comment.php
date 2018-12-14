<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'call_id', 'comment',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
