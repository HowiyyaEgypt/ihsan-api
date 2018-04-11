<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Get all of the users that are assigned this location.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'locationable');
    }

    /**
     * Get all of the users that are assigned this location.
     */
    public function organizations()
    {
        return $this->morphedByMany('App\Organization', 'locationable');
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
    public function dropedMeals()
    {
        return $this->hasMany('App\Meal', 'drop_location_id');
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
