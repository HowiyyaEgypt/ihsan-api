<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lng',
        'lat',
        'city_id',
        'locationable_type',
        'locationable_id',
        'favorite',
        'is_visible',
        'description'
    ];

      /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'favorite' => 'boolean',
        'is_visible' => 'boolean',
        'lat' => 'double',
        'lng' => 'double',
    ];
    
    /**
     * Get all of the owning locationable models.
     */
    public function locationable()
    {
        return $this->morphTo();
    }

    /**
     * the city of the location
     */
    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

    /**
     * The meals that was picked up from this location
     */
    public function pickUpMeals()
    {
        return $this->hasMany('App\Meal', 'pick_up_location_id');
    }

    /**
     * The deliveries that was picked up from this location
     */
    public function pickUpDeliveries()
    {
        return $this->hasMany('App\Delivery', 'pick_up_location_id');
    }

    /**
     * The meals that was picked up from this location
     */
    public function kitchens()
    {
        return $this->hasMany('App\Kitchen');
    }

    /**
     * The donations that was donated at this location
     */
    public function donations()
    {
        return $this->hasMany('App\Donation');
    }

    /**
     * get the nearest locations
     */
    public function scopeNearLocations($query, $lat, $lng, $range = 5)
    {
        $select = "locations.*, 6371 * 2 * ASIN(SQRT( POWER(SIN((" .$lat. " - lat)*pi()/180/2),2) + COS(".$lat."*pi()/180 )*COS(lat*pi()/180)*POWER(SIN((".$lng."-lng)*pi()/180/2),2))) as distance";

        $query->selectRaw( $select )
            ->having('distance', '<=', $range)
            ->orderBy('distance', 'ASC');
    }

     /**
     * Alias For scopeNearLocations
     */
    public function scopeNearBy( $query, $long, $lat, $range = 5 )
    {
        $query->nearLocations( $long, $lat, $range );
    }
}
