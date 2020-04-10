<?php

namespace App;

use App\Scopes\SubCategoryScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SubCategory extends Authenticatable
{
    use Notifiable;

    protected $table = 'sub_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'link',
        'title',
        'description',
        'summary',
        'email',
        'address',
        'time',
        'category_id',
        'major_id',
        'uni_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function uni()
    {
        return $this->belongsTo('App\Uni','uni_id','id');
    }
    public function major()
    {
        return $this->belongsTo('App\Major','major_id','id');
    }
    public function category()
    {
        return $this->belongsTo('App\Category','category_id','id');
    }
        protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SubCategoryScope());
    }
}
