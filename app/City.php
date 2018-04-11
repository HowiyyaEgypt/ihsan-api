<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The locations which belong to the city object
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }
}
