<?php

namespace App\Exceptions\Api;
use App\Services\APIException;

use Exception;

class ValidationException extends APIException
{
    const ERR_CODE = 470;

	public function __construct( $message = null )
	{
		parent::__construct( $message );
	}
}
