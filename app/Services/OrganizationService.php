<?php

namespace App\Services;

use App\Organization;
use App\User;
use Illuminate\Http\Request;
use App\Exceptions\Api\ValidationException;

trait OrganizationService {

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function createNewOrganization(Request $request, User $user)
    {
        $email = $request->get('email');    
        $bio = $request->get('bio');    
        $name = $request->get('name');    
        $founder_id = $user->id;

        $organization = Organization::create(['email' => $email, 'bio' => $bio, 'name' => $name, 'founder_id' => $founder_id]);

        return $organization;
    }

    /**
     * Check if a user can manage an organization
     * source is (1 -> api) , (2 -> frontend)
     *
     * @param User $user
     * @param Organization $organization
     * @param [type] $source
     * @return boolean
     */
    public function canManage(User $user, Organization $organization, $source)
    {
        // if the user hasn't joined the organization, then he/she can't manage it
        if (!$organization->users->contains($user)) {

            switch ($source) {

                case 1:
                    throw new ValidationException(trans('messages.organization.unauthorized'));
                break;
    
                case 2:
                    // TODO: handle frontend
                break;
    
            }
        } 

        // all is clear, just return
        else {
            return;
        }
    }

}