<?php

namespace App\Http\Resources\Api\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ComplexDeliveryResource extends JsonResource
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
            'meal_id' => $this->meal_id,
            'kitchen_id' => $this->kitchen_id,
            'kitchen_name' => $this->kitchen->name,
            'meal_donor_id' => $this->meal->users->first()->id,
            'meal_donor_name' => $this->meal->users->first()->name,
            'meal_description' => $this->meal->description,
            'meal_stage' => $this->meal->stage,
            'meals_bellies' => $this->meal->bellies,
            'location_description' => $this->pickUpLocation->description,
            'pickup_date' => ( new Carbon($this->pickup_date) )->toDateTimeString(),
            'delivery_date' => (!empty($this->delivery_date)) ? ( new Carbon($this->delivery_date) )->toDateTimeString() : 'Not delivered yet',
        ];
    }
}
