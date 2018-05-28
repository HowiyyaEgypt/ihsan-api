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
        'description',
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

    /**
     * The meals that needs to be delivered
     *
     * @param [type] $query
     * @return void
     */
    public function scopeNeedsToBeDelivered($query)
    {
        return $query->where('stage', 0);
    }

    /**
     * The meals that are currently being delivered
     *
     * @param [type] $query
     * @return void
     */
    public function scopeCurrentlyBeingDelivered($query)
    {
        return $query->whereIn('stage', [1,2]);
    }

    /**
     * The meals that has reached and received by the kitchen
     *
     * @param [type] $query
     * @return void
     */
    public function scopeReceivedByKitchen($query)
    {
        return $query->where('stage', 3);
    }
}
