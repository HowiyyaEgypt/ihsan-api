<?php

namespace App\Http\Resources\Api\Organization;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationLocationUtilsResource extends JsonResource
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
            'cities' => \App\City::all(),
            'locations' => $this->locations
        ];
    }
}
