<?php

namespace App\Http\Resources\Api\Tracking;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDeliveriesTracking extends JsonResource
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
            'id' => $this->id,
            'meal_donor_id' => $this->meal->users->first()->id,
            'meal_donor_name' => $this->meal->users->first()->name,
            'kitchen_id' => $this->kitchen->id,
            'kitchen_name' => $this->kitchen->name,
            'meal_id' => $this->meal->id,
            'meal_name' => $this->meal->name,
            'meal_description' => $this->meal->description,
            'meal_stage' => $this->meal->stage,
            'meals_bellies' => $this->meal->bellies,
            'location_id' => $this->pickUpLocation->id,
            'location_description' => $this->pickUpLocation->description,
            'pickup_date' => $this->pickup_date,
            'delivery_date' => (!empty($this->delivery_date)) ?  $this->delivery_date : 'Not delivered yet',
        ];
    }
}
