<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\User;

use App\Exceptions\Api\ValidationException;
use App\Exceptions\Api\InvalidCredentialsException;

use App\Http\Resources\Api\User\UserResource;

class UserController extends Controller
{

    /**
     * @SWG\Info(title="Ihsan APIs Documentation", version="1.0")
    */

    /**
     * Register a new user
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:2',
            'password'  => 'required|min:6',
            'gender'    => 'required|in:1,2',
            'email'     => 'required|email|unique:users,email'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        $user = User::create($request->only('name', 'password', 'email', 'gender'));

        $user_resource = (new UserResource($user))->additional(['success' => true, 'message' => 'A new user was created!']);
        $user_resource->setAdditionalData($user);

        return $user_resource->response()->setStatusCode(200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        // TODO: store new FCM token

        $validator = Validator::make($request->all(), [
            'email'     => 'required|email|exists:users,email',
            'password'  => 'required'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->first());

        $email = $request->get('email');
        $password = $request->get('password');

        $user = User::where('email', $email)->first();

        // TODO: add trans file
        if (empty($user) || (!empty($user) && !(\Hash::check($password, $user->password))))
            throw new InvalidCredentialsException(trans('auth.failed'));

        $user_resource = (new UserResource($user))->additional(['success' => true, 'message' => 'A new user was created!']);
        $user_resource->setAdditionalData($user);

        return $user_resource->response()->setStatusCode(200);
    }
}
