<?php

namespace App\Http\Resources\Api\Kitchen;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Meal\ComplexMealResource;
use Carbon\Carbon;

class ComplexKitchenResource extends JsonResource
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

        return  [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_opened' => (boolean) $this->is_opened,
            'can_manage' => (boolean) $this->organization->canManage(),
            'opening_time' => (new Carbon($this->opening_time))->toDateTimeString(),
            'closing_time' => (new Carbon($this->closing_time))->toDateTimeString(),
            'city_id' => $this->city->id,
            'location_id' => $this->location->id,
            'location_description' => $this->location->description,
            'organization_id' => $this->organization->id,
            'organization_name' => $this->organization->name,
            'meals_need_to_be_delivered_count' => $this->meals()->needsToBeDelivered()->count(),
            'meals_currently_being_delivered_count' => $this->meals()->currentlyBeingDelivered()->count(),
            'meals_delivered_count' => $this->meals()->receivedByKitchen()->count(),
            'meals_need_to_be_delivered' => ComplexMealResource::collection($this->meals()->needsToBeDelivered()->get()),
            'meals_currently_being_delivered' => ComplexMealResource::collection($this->meals()->currentlyBeingDelivered()->get()),
            'meals_delivered' => ComplexMealResource::collection($this->meals()->receivedByKitchen()->get()),
        ];
    }
}
