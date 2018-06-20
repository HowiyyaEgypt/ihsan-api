<?php

namespace App\Services;

use App\Meal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\Api\ValidationException;
use App\Events\Meal\NewMealWasDonated;

trait MealService {

    public function donateNewMeal(User $user, Request $request)
    {
        $meal = $user->meals()->create($request->only('bellies', 'kitchen_id', 'description','pick_up_location_id'));

        if (count($request->file('photos')) > 1) {

            foreach($request->file('photos') as $key => $photo) {

                \Log::info(['dd' => $photo]);
                $filename = time().'.'.$photo->getClientOriginalExtension();
                $photo->move(public_path('photos'), $filename);

            }

        } elseif (count($request->file('photos')) == 1) {
            $filename = time().'.'.request()->photos[0]->getClientOriginalExtension();
            request()->photos[0]->move(public_path('photos'), $filename);
        }

        if (!empty($request->get('pickup_location_id'))) {
            event(new NewMealWasDonated($user, $meal, 1));
        } else {
            event(new NewMealWasDonated($user, $meal, 2));
        }

        return $meal;
    }

}