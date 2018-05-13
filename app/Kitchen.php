<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kitchen extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'comment',
        'organization_id',
        'location_id',
        'opening_time',
        'closing_time',
        'is_opened'
    ];

    /**
     * A scope for kitches which is still opened
     *
     * @param [type] $query
     * @return void
     */
    public function scopeStillOpened($query)
    {
        return $query->where('is_opened', true);
    }

    /**
     * A scope for kitches which is closed
     *
     * @param [type] $query
     * @return void
     */
    public function scopeIsClosed($query)
    {
        return $query->where('is_opened', false);
    }

    /**
     * A scope for kitches which is still opened - closing time is not due yet
     *
     * @param [type] $query
     * @return void
     */
    public function scopeStillHasTime($query)
    {
        return $query->where('closing_time', '>=', Carbon::now());
    }

     /**
     * A scope for kitches the should be closed
     *
     * @param [type] $query
     * @return void
     */
    public function scopePastDueClosingTime($query)
    {
        return $query->where('closing_time', '<=', Carbon::now());
    }

    /**
     * The city that the kicthen belongs to
     *
     * @return void
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    /**
     * The Organization that the kicthen belongs to
     *
     * @return void
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    /**
     * The location that the kicthen belongs to
     *
     * @return void
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * The meals of the kitchen
     *
     * @return void
     */
    public function meals()
    {
        return $this->hasMany('App\Meal');
    }
}
