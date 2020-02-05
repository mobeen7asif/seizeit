<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MajorCategory extends Authenticatable
{
    use Notifiable;

    protected $table = 'major_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'major_id','category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function major()
    {
        return $this->belongsTo('App\Major','major_id','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category','category_id','id');
    }

}
