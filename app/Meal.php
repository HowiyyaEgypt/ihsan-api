<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /**
     * The drop location for this meal
     */
    public function delivery()
    {
        return $this->hasOne('App\Delivery');
    }

    /**
     * The pick up location for this meal
     */
    public function pickUpLocation()
    {
        return $this->belongsTo('App\Location', 'pick_up_location_id');
    }

    /**
     * The drop location for this meal
     */
    public function dropLocation()
    {
        return $this->belongsTo('App\Location', 'drop_location_id');
    }

    /**
     * Get all of the users that has donated this delivery.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'mealable');
    }

    /**
     * Get all of the organizations that has donated this meal.
     */
    public function organizations()
    {
        return $this->morphedByMany('App\Organization', 'mealable');
    }
}
