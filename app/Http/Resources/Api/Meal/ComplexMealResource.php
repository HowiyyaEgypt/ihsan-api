<?php

namespace App\Http\Resources\Api\Meal;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ComplexMealResource extends JsonResource
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
            'donor_id' => $this->users->first()->id,
            'donor_name' => $this->users->first()->name,
            'delivery_id' => (!empty($this->delivery)) ? $this->delivery->id: null,
            'deliverer_id' => (!empty($this->delivery)) ? $this->delivery->users->first()->id : $this->users->first()->id,
            'deliverer_name' => (!empty($this->delivery)) ? $this->delivery->users->first()->name : 'Delivered by the donor',
            'kitchen_id' => $this->kitchen->id,
            'kitchen_name' => $this->kitchen->name,
            'stage' => $this->stage,
            'bellies' => $this->bellies,
            'description' => $this->description,
            'pickup_date' => (!empty($this->delivery)) ? (new Carbon($this->delivery->pickup_date))->toDateTimeString(): (new Carbon($this->created_at))->toDateTimeString(),
            'delivery_date' => (!empty($this->delivery)) ? (!empty($this->delivery->delivery_date)) ? (new Carbon($this->delivery->delivery_date))->toDateTimeString() : 'Not delivered yet' : (new Carbon($this->created_at))->toDateTimeString(),
            'pickup_mode' => (!empty($this->pickup_location_id)) ? 1:2,
            'is_donated_by_me' => (empty($this->pickup_location_id) && empty($this->delivery) && $this->stage > 0 ) ? true: false,
            'is_delivered_by_me' => (!empty($this->delivery) && $this->delivery->users->contains(auth()->user())) ? true: false,
        ];
    }
}
