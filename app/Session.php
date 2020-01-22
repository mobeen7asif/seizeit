<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Session extends Authenticatable
{
    use Notifiable;

    protected $table = 'sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time', 'title', 'description','image','event_id','place','send_status','speakers'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at'
    ];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
    public function sessionEvent(){
        return $this->hasMany('App\SessionSpeaker','session_id');
    }
    public function sessionSpeakers(){
        return $this->hasMany('App\SessionSpeaker','session_id');
    }
}
