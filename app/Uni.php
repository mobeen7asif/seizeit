<?php

namespace App;

use App\Scopes\UniScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Uni extends Authenticatable
{
    use Notifiable;

    protected $table = 'uni';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'designation', 'image','uni_detail','sort_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at'
    ];
    public function speakers(){
        return $this->hasMany('App\SessionSpeaker','speaker_id');
    }

/*    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UniScope());
    }*/
}
