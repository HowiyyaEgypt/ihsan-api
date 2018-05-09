<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;

class CitiesController extends Controller
{
    public function allCities(Request $request)
    {
        return response()->json(['data' => City::all(), 'success' => true, 'message' => 'listing all cities'], 200);
    }
}
