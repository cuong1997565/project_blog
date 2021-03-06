<?php

namespace FTW\Repositories\Districts;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /**
     * Disable timestamps
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Fillable definition
     * @var array
     */
    protected $fillable = ['name', 'city_id', 'slug', 'zipcode', 'order', 'status'];

    /**
     * Relationship with city
     * @return [type]        [description]
     */
    public function city()
    {
        return $this->belongsTo(\FTW\Repositories\Cities\City::class);
    }

    /**
     * Relationship with user
     * @return [type] [description]
     */
    public function users()
    {
        return $this->hasMany(\FTW\User::class);
    }
}
