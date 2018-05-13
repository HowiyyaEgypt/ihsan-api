<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;

use App\Organization;
use App\Services\APIAuthTrait;
use App\Services\OrganizationService;
use App\Http\Resources\Api\Organization\OrganizationsResource;
use App\Http\Resources\Api\Organization\ComplexOrganizationResource;
use App\Http\Resources\Api\User\MixedOrganizations;

use App\Exceptions\Api\ValidationException;

class OrganizationController extends Controller
{
    use APIAuthTrait, OrganizationService;
    
    /**
     * Reutrns all registered organizations
     * accessed by all
     *
     * @param Request $request
     * @return void
     */
    public function all(Request $request)
    {

        $organizations_resource = (OrganizationsResource::collection(Organization::all()))->additional(['success' => true, 'message' => 'All organizations has been retrived']);

        return $organizations_resource->response()->setStatusCode(200);
        
    }

    /**
     * Reutrns all the organizations that the user has joined + what he/she can join
     * accessed by a user
     *
     * @param Request $request
     * @return void
     */
    public function mixed(Request $request)
    {
        $user = $this->APIAuthenticate();
        
        $mixed_organizations = (new MixedOrganizations($user))->additional(['success' => true, 'message' => 'Mixed organizations has been retrived']);

        return $mixed_organizations->response()->setStatusCode(200);
        
    }

    /**
     * view an organization - accessed by all
     *
     * @param Request $request
     * @return void
     */
    public function view(Request $request, Organization $organization)
    {
        // to access them from the api resource
        $request->request->add(['organization_id' => $organization->id]);
        $request->request->add(['kitchens_ids' => $organization->kitchens->pluck('id')->toArray() ]);

        $organization_resource = (new ComplexOrganizationResource($organization))->additional(['success' => true, 'message' => 'Organizations has been retrived']);
        
        return $organization_resource->response()->setStatusCode(200);
    }

    /**
     * join an organization
     *
     * @param Request $request
     * @return void
     */
    public function join(Request $request, Organization $organization)
    {
        $user = $this->APIAuthenticate();

        // to access them from the api resource
        $request->request->add(['organization_id' => $organization->id]);
        $request->request->add(['kitchens_ids' => $organization->kitchens->pluck('id')->toArray() ]);

        $check_if_already_a_member = $user->organizations()->where('organization_id', $organization->id)->exists();

        if($check_if_already_a_member)
            throw new ValidationException("You are already a member in this orgnization");

        $user->organizations()->attach($organization);

        $organization_resource = (new ComplexOrganizationResource($organization))->additional(['success' => true, 'message' => 'You have joined the organization successfully']);
        
        return $organization_resource->response()->setStatusCode(200);
            
    }

    /**
     * leavel an organization
     *
     * @param Request $request
     * @return void
     */
    public function leave(Request $request, Organization $organization)
    {
        $user = $this->APIAuthenticate();

        // to access them from the api resource
        $request->request->add(['organization_id' => $organization->id]);
        $request->request->add(['kitchens_ids' => $organization->kitchens->pluck('id')->toArray() ]);

        $check_if_already_a_member = $user->organizations()->where('organization_id', $organization->id)->exists();

        if(!$check_if_already_a_member)
            throw new ValidationException("You didn't join the organzation in the first place");

        if($organization->administrator_id == $user->id)
            throw new ValidationException("The administrator can't leave the organization");

        $user->organizations()->detach($organization);

        $organization_resource = (new ComplexOrganizationResource($organization))->additional(['success' => true, 'message' => 'You have left the organization']);
        
        return $organization_resource->response()->setStatusCode(200);
    }

    /**
     * Register a new organization
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $user = $this->APIAuthenticate();
        
        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|unique:organizations,email',
            'name'          => 'required|min:2',
            'bio'           => 'required|min:10'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        $organization =  $this->createNewOrganization($request, $user);

        return response()->json(['success' => true, 'message' => 'A new organization is created'], 200);
    }
}
