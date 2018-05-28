<?php

namespace App\Http\Resources\Api\Tracking;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMealsTracking extends JsonResource
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
            'meal_donor_id' => $this->users->first()->id,
            'meal_donor_name' => $this->users->first()->name,
            'kitchen_id' => $this->kitchen->id,
            'kitchen_name' => $this->kitchen->name,
            'stage' => $this->stage,
            'bellies' => $this->bellies,
            'description' => $this->description,
            'pickup_date' => (!empty($this->delivery)) ? $this->delivery->pickup_date : $this->created_at,
            'delivery_date' => (!empty($this->delivery)) ? (!empty($this->delivery->delivery_date)) ? $this->delivery->delivery_date : 'Not delivered yet' : $this->created_at,
            'pickup_mode' => (!empty($this->pickup_location_id)) ? 1:2,
            'is_donated_by_me' => (empty($this->pickup_location_id) && empty($this->delivery) && $this->stage > 0 ) ? true: false,
        ];
    }
}
