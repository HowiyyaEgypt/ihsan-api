<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\APIAuthTrait;
use App\Http\Resources\Api\Tracking\UserMealsAndDeliveriesTrackingResource;

class TrackingController extends Controller
{
    use APIAuthTrait;

    public function all(Request $request)
    {
        $user = $this->APIAuthenticate();
        
        $user_resource = (new UserMealsAndDeliveriesTrackingResource($user))->additional(['success' => true, 'message' => 'Tracking has been retrived']);

        return $user_resource->response()->setStatusCode(200);
        
    }
}
