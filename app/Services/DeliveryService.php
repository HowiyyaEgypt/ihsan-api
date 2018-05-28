<?php

namespace App\Services;

use App\Delivery;
use App\Meal;
use App\Kitchen;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\Api\ValidationException;

trait DeliveryService {

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param User $user
     * @param Meal $meal
     * @param Kitchen $kitchen
     * @param [type] $source
     * @return void
     */
    protected function deliver(Request $request, User $user, Meal $meal, Kitchen $kitchen, $source)
    {
        $err = null;

        if ($meal->kitchen_id != $kitchen->id)
            $err = "Invalid request, the meal doesn't belong to this kitchen!";
        elseif(!empty($meal->delivery) && $meal->delivery->users->contains($user))
            $err = "You already picked this meal for delivery!";
        elseif ($meal->stage > 0 || !empty($meal->delivery))
            $err = "Someone else already picked this meal for delivery!";

        if (!is_null($err)) {

            switch ($source) {
                case 1:
                    throw new ValidationException($err);
                break;
    
                case 2:
                    // TODO: handle frontend exceptions
                break;
            }
        }

        // creating the delivery object
        $delivery = Delivery::create([
            'description'           => $request->get('description'),
            'pickup_date'           => Carbon::now(),
            'meal_id'               => $meal->id,
            'kitchen_id'            => $meal->kitchen_id,
            'pick_up_location_id'   => $meal->pick_up_location_id,
        ]);

        // updating the meal status
        $meal->update(['stage' => 1]);

        // attaching the delivery to a user
        $delivery->users()->sync($user);
        
        return $delivery;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param User $user
     * @param Meal $meal
     * @param Delivery $delivery
     * @return boolean
     */
    public function cancel(Request $request, User $user, Meal $meal, Delivery $delivery, $source)
    {
        $err = null;

        if ($meal->stage == 0 || empty($meal->delivery))
            $err = "This meals hasn't been picked for delivery yet";
        elseif(!$delivery->users->contains($user)) {
            // this means that the person who is trying to cancel the delivery might be the kitchen admin
            $organization = $meal->kitchen->organization;

            if(!$user->organizations->where('pivot.can_manage', 1)->contains($organization))
                $err = "You are not allowed to cancel this delivery";
        }

        if (!is_null($err)) {
            switch ($source) {
                case 1:
                    throw new ValidationException($err);
                break;
    
                case 2:
                break;
            }
        }

        $delivery->delete();

        // updating the meal status
        $meal->update(['stage' => 0]);

        return $meal;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param User $user
     * @param Meal $meal
     * @param Delivery $delivery
     * @param [type] $source
     * @param [type] $mode
     * @return void
     */
    protected function confirmReception(Request $request, User $user, Meal $meal, Delivery $delivery, $source, $mode)
    {
        $err = null;
        $kitchen = $meal->kitchen;
        $organization = $meal->kitchen->organization;

        switch($mode) {
            
            // case 1 : normal user
            case 1:

                if ($meal->stage == 0 || empty($meal->delivery))
                    $err = "This meals hasn't been picked for delivery yet";
                elseif(!$delivery->users->contains($user)) 
                    $err = "You are not allowed to confirm this delivery";

            break;

            // case 2 : kitchen admin
            case 2:

            \Log::info(['u0' => empty($user->organiztions)]);
            \Log::info(['u1' => $user->organizations->contains($organization)]);
            \Log::info(['u2' => $organization->canManage()]);

                if(empty($user->organizations)  || !$user->organizations->contains($organization) || !$organization->canManage()) 
                    $err = "You are not allowed to confirm this delivery";
                elseif ($meal->stage == 0 || empty($meal->delivery))
                    $err = "This meals hasn't been picked for delivery yet";

            break;
        }

        

        if (!is_null($err)) {
            switch ($source) {
                case 1:
                    throw new ValidationException($err);
                break;
    
                case 2:
                break;
            }
        }

        switch($mode) {

            case 1:

                // updating the meal status
                $meal->update(['stage' => 2]);

                // updating pickup date
                $delivery->update(['pickup_date' => Carbon::now()]);

            break;

            case 2:

                // updating the meal status
                $meal->update(['stage' => 3]);

                // updating pickup date
                $delivery->update(['delivery_date' => Carbon::now()]);

            break;

        }
        
        return $delivery;
    } 
}