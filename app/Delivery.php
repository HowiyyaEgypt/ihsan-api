<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'photo',
        'pickup_date',
        'delivery_date',
        'meal_id',
        'pick_up_location_id',
        'kitchen_id'
    ];

    /**
     * The meal that the delivery belongs to
     */
    public function meal()
    {
        return $this->belongsTo('App\Meal');
    }

    /**
     * The pick up location for this delivery
     */
    public function pickUpLocation()
    {
        return $this->belongsTo('App\Location', 'pick_up_location_id');
    }

    /**
     * The drop location for this delivery
     */
    public function kitchen()
    {
        return $this->belongsTo('App\Kitchen', 'kitchen_id');
    }

    /**
     * Get all of the users that has donated this delivery.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'deliverable');
    }

    /**
     * Get all of the organizations that has donated this delivery.
     */
    public function organizations()
    {
        return $this->morphedByMany('App\Organization', 'deliverable');
    }
    
}
