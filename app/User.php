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
        return $this->morphToMany('App\Meal', 'mealable');
    }

    /**
     * Get all of the deliveries for the user.
     */
    public function deliveries()
    {
        return $this->morphToMany('App\Meal', 'deliverable');
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
        return $this->belongsToMany('App\Organization');
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
