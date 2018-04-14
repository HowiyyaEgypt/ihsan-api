<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bellies',
        'comment',
        'photo',
        'expiration_date',
        'stage',
        'pick_up_location_id',
        'kitchen_id'
    ];

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
    public function kitchen()
    {
        return $this->belongsTo('App\Kitchen');
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
