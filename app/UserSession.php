<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $table = 'user_sessions';
    protected $fillable = [
        'id', 'user_id', 'device_id','device_token','session_id','device_type',
    ];
}
