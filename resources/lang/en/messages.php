<?php

return [

    'meal' => [
        'min_expiration_date' => 'The min expriation date must be one day at least'
    ],

    'location' => [
        'location_exists' => 'You already have this location',
        'unauthorized_location' => "You don't own this location"
    ],

    'organization' => [
        'unauthorized' => "You aren't authorized to do this action"
    ],

    'kitchen' => [
        'other_kitchens_still_has_time' => "Another kitchen in the same location already has some time left",
        'other_kitchens_still_opened'   => "You can't have more than one opened kitchen at the same time in the same location",
        'invalid_time_duaration'   => "Please enter a valid duration",
    ]

];