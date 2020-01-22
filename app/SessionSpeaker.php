<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SessionSpeaker extends Authenticatable
{
    use Notifiable;

    protected $table = 'session_speakers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_id', 'speaker_id'
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
//    public function speaker()
//    {
//        return $this->belongsTo('App\Uni');
//    }
    public function speaker(){
        return $this->hasOne('App\Uni','id','speaker_id');
    }

}
