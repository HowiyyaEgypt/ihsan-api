<?php

namespace App\Services;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\Api\UnauthenticatedException;

trait APIAuthTrait
{
	public function APIAuthenticate()
	{
		if( !(\Request::get( 'token' )) && !(app('request')->bearerToken()) )
			throw new UnauthenticatedException;

		try {
			if (!($user = JWTAuth::parseToken()->authenticate()))
			{
				throw new UserNotFoundException;
			}
		}
		catch( TokenExpiredException $e ){
			throw new TokenExpiredException('Token has expired', 400);
		}

		return $user;
	}
}
