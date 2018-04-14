<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use JWTAuth;

use App\Organization;
use App\Services\APIAuthTrait;
use App\Services\OrganizationService;

use App\Exceptions\Api\ValidationException;

class OrganizationController extends Controller
{
    use APIAuthTrait, OrganizationService;
    
    /**
     * Register a new organization
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $user = $this->APIAuthenticate();
        
        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|unique:organizations,email',
            'name'          => 'required|min:2',
            'bio'           => 'required|min:10'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        $organization =  $this->createNewOrganization($request, $user);

        return response()->json(['success' => true, 'message' => 'A new organization is created'], 200);
    }
}
