<?php

namespace App\Http\Resources\Api\Organization;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationsResource extends JsonResource
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
            'administrator_name' => $this->administrator->name,
            'kitchens_count' => $this->kitchens->count(),
            'donated_meals' => $this->originalMeals->count(),
            'original_meals' => $this->donatedMeals->count(),
            'users_count' => $this->users->count(),
            'locations' => $this->locations
        ];
    }
}
