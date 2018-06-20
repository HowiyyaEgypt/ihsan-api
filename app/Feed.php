<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feedable_id',
        'feedable_type',
        'full_message',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'full_message' => 'array',
    ];

    /**
     * The owner of the feed
     */
    public function feedableable()
    {
        return $this->morphTo();
    }
}
