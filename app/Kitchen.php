<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
