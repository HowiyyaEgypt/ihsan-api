<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all of the locations for the user.
     */
    public function locations()
    {
        return $this->morphMany('App\Location', 'locationable');
    }

    /**
     * Get all of the meals for the user.
     */
    public function meals()
    {
        return $this->morphToMany('App\Meal', 'mealable')->withTimestamps();
    }

    /**
     * Gets all of the meals for the user that he/she donated for a certain organization
     * we get the organizaition id from the request (store it manually)
     */
    public function mealsDonatedForAnOrganzation($organization_id = null)
    {
        if(!is_null($organization_id)) {
            $kitchens_ids = \App\Kitchen::where('organization_id', $organization_id)->pluck('id')->toArray();
        } else {
            $kitchens_ids = request()->get('kitchens_ids');
        }

        return $this->morphToMany('App\Meal', 'mealable')->whereHas('kitchen', function($q) use ($kitchens_ids) {
            $q->whereIn('id', $kitchens_ids);
        })->withTimestamps();
    }

    /**
     * Get all of the deliveries for the user.
     */
    public function deliveries()
    {
        return $this->morphToMany('App\Delivery', 'deliverable');
    }

    /**
     * Get all of the donations for the user.
     */
    public function donations()
    {
        return $this->morphToMany('App\Donation', 'donationable');
    }

    /**
     * Get all of the organizations that user has joined
     */
    public function organizations()
    {
        return $this->belongsToMany('App\Organization')->withPivot('can_manage');
    }

    /**
     * Get all of the organizations that user can still join
     */
    public function avaliableToJoinrOganizations()
    {
        $already_joined_organizations_ids = $this->organizations->pluck('id')->toArray();;
        return \App\Organization::whereNotIn('id',$already_joined_organizations_ids)->get();
    }

    /**
     * Get all of the organizations that user can still join - as an attribute
     */
    public function getAvaliableToJoinrOganizationsAttribute()
    {
        if( $this->relationLoaded( 'avaliableToJoinrOganizations' ) )
            return $this->relations[ 'avaliableToJoinrOganizations' ];

        $this->setRelation( 'avaliableToJoinrOganizations', $this->avaliableToJoinrOganizations() );
            return $this->relations[ 'avaliableToJoinrOganizations' ];
    }


    /**
     * returtns the the meals that a user has donated for an organization
     */
    public function mealsDonatedForAnOrganization($organization_id)
    {
        $kitchens_ids = \App\Kitchen::where('organization_id', $organization_id)->pluck('id')->toArray();

        return $this->meals()->whereIn('kitchen_id', $kitchens_ids)->get();
    }

    /**
     * returtns the count of the meals that a user has donated for an organization
     */
    public function mealsDonatedForAnOrganizationCount($organization_id)
    {
        return $this->mealsDonatedForAnOrganization($organization_id)->count();
    }

    /**
     * Password setter
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
