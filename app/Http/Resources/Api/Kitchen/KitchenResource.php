<?php

namespace App\Http\Resources\Api\Kitchen;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Kitchen;

class KitchenResource extends JsonResource
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
            'name' => $this->name,
            'comment' => $this->comment,
            'city_id' => $this->city->id,
            'city_name' => $this->city->name_en,
            'organization_id' => $this->organization->id,
            'organization_name' => $this->organization->name,
            'location_id' => $this->location->id,
            'location_lat' => $this->location->lat,
            'location_lng' => $this->location->lng,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'is_opened' => (boolean) $this->is_opened,
        ];
    }
}
