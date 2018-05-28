<?php

namespace App\Http\Resources\Api\Tracking;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Tracking\UserMealsTracking;
use App\Http\Resources\Api\Tracking\UserDeliveriesTracking;

class UserMealsAndDeliveriesTrackingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'meals' => UserMealsTracking::collection($this->meals()->with('kitchen','delivery')->orderBy('created_at','desc')->get()),
            'deliveries' => UserDeliveriesTracking::collection($this->deliveries()->with('meal','meal.users','kitchen', 'pickUpLocation')->get()),
        ];
    }
}
