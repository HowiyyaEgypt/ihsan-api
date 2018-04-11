<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * Get all of the user who joined the organization.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get all of the locations for the organization.
     */
    public function locations()
    {
        return $this->morphToMany('App\Location', 'locationable');
    }

    /**
     * Get all of the meals for the organization.
     */
    public function meals()
    {
        return $this->morphToMany('App\Meal', 'mealable');
    }

    /**
     * Get all of the deliveries for the organization.
     */
    public function deliveries()
    {
        return $this->morphToMany('App\Meal', 'deliverable');
    }

    /**
     * Get all of the donations for the organization.
     */
    public function donations()
    {
        return $this->morphToMany('App\Donation', 'donationable');
    }
}
