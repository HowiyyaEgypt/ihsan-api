<?php

namespace App\Http\Resources\Api\Organization;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersAsVolunteers extends JsonResource
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
            'meals_donated_for_an_organizations_count' => $this->mealsDonatedForAnOrganizationCount($request->get('organization_id'))
        ];
    }
}
