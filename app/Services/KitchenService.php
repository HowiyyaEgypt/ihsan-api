<?php

namespace App\Services;

use App\Organization;
use App\Kitchen;
use App\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\Api\ValidationException;
use App\Events\Kitchen\NewKitchenWasOpened;

trait KitchenService {

    /**
     * Nearby kitchens
     *
     * @param Request $request
     * @param Location $location
     * @return void
     */
    public function nearByKitchens(Request $request, Location $location = null)
    {
        $nearby_kitchens = null;

        switch ($request->get('mode')) {

            // we search using the city id
            case 1:

                $nearby_kitchens = Kitchen::where('city_id', $request->get('city_id'))->stillHasTime()->with(['city','organization','location'])->get();
                break;

            
            // we search using the lat and lng
            case 2:

                $lat = $request->get('lat');
                $lng = $request->get('lng');

                $nearby_locations_have_kitchens = Location::nearLocations($lat, $lng)->has('kitchens')->pluck('id');

                $nearby_kitchens = Kitchen::whereIn('location_id', $nearby_locations_have_kitchens)
                ->with(['city','organization','location'])
                ->stillHasTime()->get();
                break;
        }
    
        return $nearby_kitchens;
    }

    /**
     * creating a new kitchen
     *
     * @param Request $request
     * @param Organization $organization
     * @return void
     */
    public function createNewKitchen(Request $request, Organization $organization, $existing_location = null, $source)
    {
        // setting input
        $name = $request->get('name');    
        $description = $request->get('description');    
        $location_id = is_null($existing_location) ? $request->get('location_id') : $existing_location->id;    
        $city_id = $request->get('city_id');
        $opening_time = Carbon::createFromTimestamp($request->get('opening_time'), 'Africa/Cairo');
        $closing_time = Carbon::createFromTimestamp($request->get('closing_time'), 'Africa/Cairo');
        $is_opened = !empty($request->get('is_opened')) ? $request->get('is_opened') : true;
        $organization_id = $organization->id;

        // kitchens where closing_time >= now
        $kitches_at_the_same_location_still_has_time = $organization->kitchens()
                                                    ->where('location_id', $location_id)
                                                    ->stillHasTime()
                                                    ->get();


        if (count($kitches_at_the_same_location_still_has_time) > 0) {

            switch ($source) {

                case 1:
                    throw new ValidationException(trans('messages.kitchen.other_kitchens_still_has_time'));
                break;

                case 2:
                    // TODO: handle front end
                break;

            }

        }                                           

        // kitchens where is_opened == true
        $kitches_at_the_same_location_still_opened = $organization->kitchens()
                                                    ->where('location_id', $location_id)
                                                    ->stillOpened()
                                                    ->get();
        
        if (count($kitches_at_the_same_location_still_opened) > 0) {

            switch ($source) {

                case 1:
                    throw new ValidationException(trans('messages.kitchen.other_kitchens_still_opened'));
                break;

                case 2:
                    // TODO: handle front end
                break;

            }

        }

    
        $kitchen = Kitchen::create(['name' => $name,
        'description' => $description,
        'organization_id' => $organization_id,
        'location_id' => $location_id,
        'city_id' => $city_id,
        'opening_time' => $opening_time,
        'closing_time' => $closing_time,
        'is_opened' => $is_opened]);

        // firing the event
        event(new NewKitchenWasOpened(auth()->user(), $kitchen));

        return $kitchen;

    }

}