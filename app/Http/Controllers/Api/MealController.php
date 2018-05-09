<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use Carbon\Carbon;
use App\Meal;

use App\Services\APIAuthTrait;
use App\Http\Resources\Api\Meal\UserMeals;
use App\Services\MealService;

use App\Exceptions\Api\ValidationException;

class MealController extends Controller
{
    use APIAuthTrait, MealService;
    
    /**
     * The history of the user's meals
     */
    public function history(Request $request)
    {
        $user = $this->APIAuthenticate();
        
        $user_meals_resource = UserMeals::collection($user->meals);
        
        return $user_meals_resource;
    }

    /**
     * Donate a new meal
     */
    public function donate(Request $request)
    {
        // \Log::info(['req' => $request]);

        $user = $this->APIAuthenticate();

        $current_time_unix = Carbon::now()->timestamp;
        $valid_meal_ttl = $current_time_unix + (60 * 60 * 23); // current time + 23 hours
        
        $validator = Validator::make($request->all(), [
            'bellies'               => 'required|integer|min:1',
            // 'expiration_date'       => 'required|integer|min:'. $valid_meal_ttl ,
            'mode'                  => 'integer|in:1,2',
            'pick_up_location_id'   => 'integer|exists:locations,id',
            'kitchen_id'            => 'required|exists:kitchens,id',
            'description'           => 'required|min:5'
        ]);

        if ( $validator->fails() ){
            if($validator->errors()->has('expiration_date')){
                throw new ValidationException(trans('messages.meal.min_expiration_date'));
            }
            throw new ValidationException( $validator->errors()->first() );
        }

        $new_meal = $this->donateNewMeal($user, $request);

        return response()->json(['success' => true, 'message' => 'You successfully added a new meal!', 'data' => $new_meal], 200);
    }
}
