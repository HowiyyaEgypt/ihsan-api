<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lng',
        'lat',
        'city_id',
        'locationable_type',
        'locationable_id',
        'favorite',
        'is_visible'
    ];
    
    /**
     * Get all of the owning locationable models.
     */
    public function locationable()
    {
        return $this->morphTo();
    }

    /**
     * The meals that was picked up from this location
     */
    public function pickUpMeals()
    {
        return $this->hasMany('App\Meal', 'pick_up_location_id');
    }

    /**
     * The deliveries that was picked up from this location
     */
    public function pickUpDeliveries()
    {
        return $this->hasMany('App\Delivery', 'pick_up_location_id');
    }

    /**
     * The meals that was picked up from this location
     */
    public function kitchens()
    {
        return $this->hasMany('App\Kitchen');
    }

    /**
     * The deliveries that was picked up from this location
     */
    public function dropedDeliveries()
    {
        return $this->hasMany('App\Delivery', 'drop_location_id');
    }

    /**
     * The donations that was donated at this location
     */
    public function donations()
    {
        return $this->hasMany('App\Donation');
    }
}
