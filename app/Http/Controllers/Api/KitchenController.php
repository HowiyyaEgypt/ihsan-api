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
use App\Services\LocationService;
use App\Services\KitchenService;
use App\Http\Resources\Api\Kitchen\KitchenResource;
use App\Http\Resources\Api\Kitchen\ComplexKitchenResource;

use App\Exceptions\Api\ValidationException;


class KitchenController extends Controller
{
    
    use APIAuthTrait, OrganizationService, KitchenService, LocationService;

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
     * gets an overview of a certian kitchen
     * how many meals already delivered
     * how many meals currently being delivered
     * how many meals need to be delivered
     * opening / closing time
     * location
     *
     * @param Request $request
     * @param Kitchen $kitchen
     * @return void
     */
    public function view(Request $request, Kitchen $kitchen)
    {
        $user = $this->APIAuthenticate();

        $kitchens_resource = (new ComplexKitchenResource($kitchen))->additional(['success' => true, 'message' => 'Kitchen has been retrived']);

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
        
    }

    /**
     * upcomming kitchens - accessible by all
     *
     * @param Request $request
     * @return void
     */
    public function upcomming(Request $request, Organization $organization)
    {
        
    }

    /**
     * History of kitchens - accessible by all
     *
     * @param Request $request
     * @return void
     */
    public function history(Request $request, Organization $organization)
    {

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

        \Log::info(['req' => $request]);

        $thirty_minutes_ago = Carbon::now('Africa/Cairo')->subMinutes(30)->timestamp; // now minus 30 minutes
        $kitchen_ttl = Carbon::now('Africa/Cairo')->addMinutes(60);   // the kitchen lifespan must be at least an hour

        $validator = Validator::make($request->all(), [
            'mode'          => 'required|integer|between:1,2',
            'name'          => 'required|min:5',
            'description'   => 'required|min:5',
            'city_id'       => 'required|exists:cities,id',
            'location_id'   => 'required_without:lat,lng',
            'lat'           => 'required_without:location_id|numeric|between:-90,90',
            'lng'           => 'required_without:location_id|numeric|between:-180,180',
            'opening_time'  => 'required|integer|min:'. $thirty_minutes_ago,
            'closing_time'  => 'required|integer|min:'. $kitchen_ttl,
            'is_opened'     => 'nullable|boolean'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        // if mode == 2, then the admin is trying to create the kitchen in a new location
        // so we will create a new location the pass it to the kitchen trait
        // '2' param is for mode == organization
        // '1' param for api source
        if($request->get('mode') == 2) {
            $location =  $this->createOrRestoreLocation($request, $user, $organization, 2, 1);

            if (!empty($location)) {
                $kitchen = $this->createNewKitchen($request, $organization, $location, 1);
            }
        } 
        else {
            // 1 is the source - API
            // to throw exception in case of trying to create another kitchen in the same place at the same time
            $kitchen = $this->createNewKitchen($request, $organization, null, 1);
        }

        $kitchens_resource = (new ComplexKitchenResource($kitchen))->additional(['success' => true, 'message' => 'A new kitchen is created']);

        return $kitchens_resource->response()->setStatusCode(200);
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
