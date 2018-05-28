<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Delivery;
use App\Meal;
use App\Kitchen;
use App\Services\APIAuthTrait;
use App\Services\DeliveryService;
use App\Http\Resources\Api\Delivery\ComplexDeliveryResource;

use App\Exceptions\Api\ValidationException;


class DeliveryController extends Controller
{
    use APIAuthTrait, DeliveryService;

    /**
     * Delivering a meal
     *
     * @param Request $request
     * @param Meal $meal
     * @return void
     */
    public function pickForDelivery(Request $request, Meal $meal, Kitchen $kitchen)
    {
        $user = $this->APIAuthenticate();
        
        $delivery = $this->deliver($request, $user, $meal, $kitchen, 1);

        $delivery_resource = (new ComplexDeliveryResource($delivery))->additional(['success' => true, 'message' => 'delivery has been created']);
        return $delivery_resource->response()->setStatusCode(200);
        
        // TODO: fire event for donor, kitchen admin, to let them now of the update        
    }

    /**
     * Cancel a delivery
     *
     * @param Request $request
     * @param Meal $meal
     * @param Delivery $delivery
     * @return boolean
     */
    public function cancelDelivery(Request $request, Meal $meal, Delivery $delivery)
    {
        $user = $this->APIAuthenticate();

        $canelled_meal = $this->cancel($request, $user, $meal, $delivery, 1);

        return response()->json(['success' => true, 'message' => 'Meal delivery has been cancelled', 'data' => $canelled_meal], 200);

        // TODO: fire event for donor, kitchen admin, to let them now of the update        
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Meal $meal
     * @param Delivery $delivery
     * @return void
     */
    public function confirmMealReception(Request $request, Meal $meal, Delivery $delivery)
    {
        $user = $this->APIAuthenticate();

        $delivery = $this->confirmReception($request, $user, $meal, $delivery, 1, $request->get('mode'));

        // TODO: fire an event to let the admin know that the meal was picked

        $delivery_resource = (new ComplexDeliveryResource($delivery))->additional(['success' => true, 'message' => 'delivery has been created']);
        return $delivery_resource->response()->setStatusCode(200);
    }   
}
