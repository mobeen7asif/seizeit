<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Event extends Authenticatable
{
    use Notifiable;

    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date','place','session_text'
    ];

    public function sessions()
    {
        return $this->hasMany('App\Session','event_id');
    }
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at'
    ];
}
