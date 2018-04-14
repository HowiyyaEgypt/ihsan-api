<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'founder_id',
        'points',
        'level',
        'photo',
        'bio'
    ];

    /**
     * the founder of the organization
     */
    public function founder()
    {
        return $this->belongsTo('App\User', 'founder_id');
    }

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
        return $this->morphMany('App\Location', 'locationable');
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

    /**
     * Get all of the kitchens for the organization.
     */
    public function kitchens()
    {
        return $this->hasMany('App\Kitchen');
    }
}
