<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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
        'administrator_id',
        'points',
        'level',
        'photo',
        'bio'
    ];

    /**
     * the administrator of the organization
     */
    public function administrator()
    {
        return $this->belongsTo('App\User', 'administrator_id');
    }

    /**
     * Get all of the user who joined the organization.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Checks if the auth user can manage this organization or not
     */
    public function canManage()
    {
        $pivot = DB::table('organization_user')
                ->where('organization_id', $this->id)
                ->where('user_id', auth()->user()->id)
                ->first();

        if(!empty($pivot) && $pivot->can_manage == true)
            return true;
        else
            return false;
    }

    /**
     * Get all of the locations for the organization.
     */
    public function locations()
    {
        return $this->morphMany('App\Location', 'locationable');
    }

    /**
     * Get all of the meals for the organization - which the organization has donated itself.
     */
    public function originalMeals()
    {
        return $this->morphToMany('App\Meal', 'mealable');
    }

    /**
     * Get all of the meals for the organization - which was donated to the organization.
     */
    public function donatedMeals()
    {
        return $this->hasManyThrough('App\Meal', 'App\Kitchen');
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
