<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;

use App\Location;
use App\Services\APIAuthTrait;
use App\Services\LocationService;
use App\Http\Resources\Api\Location\UserLocations;

use App\Exceptions\Api\ValidationException;

class LocationController extends Controller
{
    use APIAuthTrait, LocationService;
    
    /**
     * The history of the user's locations
     */
    public function history(Request $request)
    {
        $user = $this->APIAuthenticate();
        
        $user_locations_resource = UserLocations::collection($user->locations()->paginate(env('PER_PAGE')));
        
        return $user_locations_resource;
    }

    /**
     * Add a new location
     */
    public function add(Request $request)
    {
        $user = $this->APIAuthenticate();

        $validator = Validator::make($request->all(), [
            'city_id'       => 'integer|exists:cities,id',
            'lat'           => 'required|numeric|between:-90,90',
            'lng'           => 'required|numeric|between:-180,180',
            'favorite'      => 'nullable|boolean',
            'description'   => 'required|min:3'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        // location trait
        // 1st: request
        // 2nd: user
        // 3rd: organization
        // 4th: mode ($user)
        // 5th: source (api, to throw exception from the trait)
        // the result will be a location object
        $location =  $this->createOrRestoreLocation($request, $user, null, 1, 1);

        return response()->json(['success' => true, 'message' => 'A new location is created', 'data' => $location], 200);
    }

    /**
     * Deleting a location if it has no meals, donation nor deliveres
     */
    public function delete(Request $request, Location $location)
    {
        $user = $this->APIAuthenticate();
        
        if (!$user->locations->contains($location) || ($user->locations->contains($location) && $location->is_visible == false))
            throw new ValidationException(trans('messages.location.unauthorized_location'));
            
        // location trait
        $delete_result = $this->deleteOrHideLocation($location);

        if ($delete_result === true)
            return response()->json(['success' => true, 'message' => 'The Location was deleted'], 200);
        else
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the location'], 400);
    }
}
