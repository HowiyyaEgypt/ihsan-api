<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    /**
     * The location that the donation belongs to
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * Get all of the users that has donated this donation.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'donationable');
    }

     /**
     * Get all of the organizations that has donated this donation.
     */
    public function organizations()
    {
        return $this->morphedByMany('App\Organization', 'donationable');
    }
}
