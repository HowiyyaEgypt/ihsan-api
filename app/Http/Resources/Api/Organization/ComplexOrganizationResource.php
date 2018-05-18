<?php

namespace App\Http\Resources\Api\Organization;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Kitchen\KitchenResource;
use App\Http\Resources\Api\Organization\UsersAsVolunteers;

class ComplexOrganizationResource extends JsonResource
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
            'can_manage' => $this->canManage(),
            'administrator_name' => $this->administrator->name,
            'total_kitchens_count' => $this->kitchens->count(),
            'locations_count' => $this->locations->count(),
            'users_count' => $this->users->count(),
            'opened_kitchens_count' => $this->kitchens()->stillOpened()->count(),
            'donated_meals_count' => $this->donatedMeals->count(),
            'original_meals_count' => $this->originalMeals->count(),
            'opened_kitchens' => KitchenResource::collection($this->kitchens()->stillOpened()->get()),
            'closed_kitchens' => KitchenResource::collection($this->kitchens()->isClosed()->get()),
            // 'users' => UsersAsVolunteers::collection($this->users),
            'users' => UsersAsVolunteers::collection($this->users()->withCount('mealsDonatedForAnOrganzation')->orderBy('meals_donated_for_an_organzation_count', 'desc')->get()),
            'locations' => $this->locations
        ];
    }
}
