<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use Carbon\Carbon;

use App\Kitchen;
use App\Organization;
use App\Location;
use App\Services\APIAuthTrait;
use App\Services\OrganizationService;
use App\Services\KitchenService;
use App\Http\Resources\Api\Kitchen\KitchenResource;

use App\Exceptions\Api\ValidationException;


class KitchenController extends Controller
{
    
    use APIAuthTrait, OrganizationService, KitchenService;

    /**
     * nearby kitchens - accessible by all
     *
     * @param Request $request
     * @return void
     */
    public function nearby(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'mode'      => 'required|integer|in:1,2',
            'city_id'   => 'required_if:mode,1|integer|exists:cities,id',            
            'lat'       => 'required_if:mode,2|required_with:lng|numeric',        
            'lng'       => 'required_if:mode,2|required_with:lat|numeric',        
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        $near_by_kitchens = $this->nearByKitchens($request, $location);


        if ($near_by_kitchens->isEmpty()) 
            throw new ValidationException("There is no available kitchens in this area");
        
            
        $kitchens_resource = (KitchenResource::collection($near_by_kitchens))->additional(['success' => true, 'message' => 'Available kitchens has been retrived']);
        return $kitchens_resource->response()->setStatusCode(200);
    }

    /**
     * today's kitchens - accessible by all
     *
     * @param Request $request
     * @return void
     */
    public function today(Request $request, Organization $organization)
    {
        $user = $this->APIAuthenticate();

        

    }

    /**
     * upcomming kitchens - accessible by all
     *
     * @param Request $request
     * @return void
     */
    public function upcomming(Request $request, Organization $organization)
    {
        $user = $this->APIAuthenticate();

        
    }

    /**
     * History of kitchens - accessible by all
     *
     * @param Request $request
     * @return void
     */
    public function history(Request $request, Organization $organization)
    {
        $user = $this->APIAuthenticate();

    }

    /**
     * Create a kitchen
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request, Organization $organization)
    {
        $user = $this->APIAuthenticate();

        // OrganizationService check, it will handle error itself, '1' is for API
        $this->canManage($user, $organization, 1);

        $now_unix = Carbon::now()->subMinutes(10)->timestamp; // now minus 10 minutes, for request delays
        $kitchen_ttl = Carbon::now()->addMinutes(60);   // the kitchen lifespan must be at least an hour

        $validator = Validator::make($request->all(), [
            'name'          => 'required|min:5',
            'location_id'   => 'required|exists:locations,id',
            'opening_time'  => 'required|integer|min:'. $now_unix,
            'closing_time'  => 'required|integer|min:'. $kitchen_ttl,
            'is_opened'     => 'nullable|boolean'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        // 1 is the source - API
        // to throw exception in case of trying to create another kitchen in the same place at the same time
        $kitchen = $this->createNewKitchen($request, $organization, 1);

        return response()->json(['success' => true, 'message' => 'A new kitchen is created'], 200);
    }

    /**
     * Edit a kitchen
     *
     * @param Request $request
     * @return void
     */
    public function edit(Request $request, Organization $organization, Kitchen $kitchen)
    {
        $user = $this->APIAuthenticate();

        // OrganizationService check, it will handle error itself, '1' is for API
        $this->canManage($user, $organization, 1);
    }

    /**
     * Delete a kitchen
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request, Organization $organization, Kitchen $kitchen)
    {
        $user = $this->APIAuthenticate();

        // OrganizationService check, it will handle error itself, '1' is for API
        $this->canManage($user, $organization, 1);
    }
}
