<?php

namespace App\Services;

use App\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\Api\ValidationException;

trait LocationService {

    /**
     * Check to create or restore or throw error
     * $source: 1 -> api, 2 -> frontend 
     * $mode: 1-> user, 2 -> organization
     * 
     * @param Request $request
     * @param [type] $user
     * @param [type] $organization
     * @param [type] $mode
     * @param [type] $source
     * @return void
     */
    public function createOrRestoreLocation(Request $request, $user, $organization, $mode, $source)
    {   
        // the value we will return later
        $location = null;

        $lat = round($request->get('lat'),8);    
        $lng = round($request->get('lng'),7);    
        $city_id = $request->get('city_id');    
        $favorite = $request->get('favorite');
        $description = $request->get('description');


        // check if the user / organization already has the same location

        switch ($mode) {

            case 1:

                $location = $user->locations
                ->where('lat', 'like', $lat)
                ->where('lng', 'like' ,$lng)
                ->first();

            break;

            case 2:

                $location = $organization->locations
                ->where('lat', 'like', $lat)
                ->where('lng', 'like', $lng)
                ->first(); 

            break;

        }

        // if empty, we will create it
        if (empty($location)) {

            $location = $this->createNewLocation($mode, $user, $lat, $lng, $city_id, $favorite, $description, $organization);
            return $location;
        } 

        // we will check if this place is visible or not
        // if visible we will throw error
        // else, we will restore it
        else {

            switch ($location->is_visible) {

                // the location is visible, throw exception
                case true:
                    
                    switch ($source) {

                        case 1:
                            throw new ValidationException(trans('messages.location.location_exists'));
                        break;

                        case 2:
                            // TODO: handle exception to front end
                        break;

                    }

                break;

                // the location is not visible, restore it
                case false:
                    $location->update(['is_visible' => true]);
                    return $location;
                break;

            }

        }

    }

    /**
     * mode (1 -> location for the user) (2 -> location for the organization)
     * favorite (is it the primary location for the user/organization)
     *
     * @param [int] $mode
     * @param [user] $user
     * @param [double] $lat
     * @param [double] $lng
     * @param [int] $city_id
     * @param boolean $favorite
     * @param [String] $description
     * @param [organization] $organization
     * @return void
     */
    public function createNewLocation($mode, $user, $lat, $lng, $city_id, $favorite, $description, $organization = null)
    {
        
        if(is_null($favorite)) {
            $favorite = false;
        }
        
        switch ($mode) {
            case 1:

                $location = Location::create(['description' => $description, 'lat' =>$lat , 'lng' => $lng , 'city_id' => $city_id, 'locationable_type' => 'App\User', 'locationable_id' => $user->id, 'favorite' => $favorite ]); 

                if ($favorite === true) {
                    $user->locations()
                    ->where('favorite', true)
                    ->where('id', '!=', $location->id)
                    ->update(['favorite' => false]);
                }

            break;

            case 2:

                $location = Location::create(['description' => $description, 'lat' => $lat , 'lng' => $lng , 'city_id' => $city_id, 'locationable_type' => 'App\Organization', 'locationable_id' => $organization->id, 'favorite' => $favorite ]); 

                if ($favorite === true) {
                    $organization->locations()
                    ->where('favorite', true)
                    ->where('id', '!=', $location->id)
                    ->update(['favorite' => false]);
                }

            break;
        }

        // all is clear .. return the location object
        return $location;
    }


    /**
     * Deleting a location if it has no meals, donation nor deliveres
     * mode (1 -> location for the user) (2 -> location for the organization)
     * 
     * @param [int] $mode
     * @param [int] $location
     * @return void
     */
    public function deleteOrHideLocation($location)
    {

        $pickup_meals_count = $location->pickUpMeals->count();
        $kitchens_count = $location->kitchens->count();
        $pickup_delivers_count = $location->pickUpDeliveries->count();
        $droped_delivers_count = $location->dropedDeliveries->count();
        $donations_count = $location->donations->count();

        if ($pickup_meals_count == 0
            && $kitchens_count == 0
            && $droped_delivers_count == 0
            && $droped_delivers_count == 0
            && $donations_count == 0)
        {
            // delete only if there is nothig assoc. with this location
            $location->delete();
            return true;
            
        }

        // otherwise we will delete it
        else {

            $location->update(['is_visible' => false]);
            return true;

        }

        return false;
    }
}