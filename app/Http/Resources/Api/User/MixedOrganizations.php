<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Organization\SimpleOrganizationsResource;

class MixedOrganizations extends JsonResource
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

            'already_joined_organizations' => SimpleOrganizationsResource::collection($this->organizations),
            'available_to_join_organizations' => SimpleOrganizationsResource::collection($this->avaliableToJoinrOganizations) ,

        ];
    }
}
