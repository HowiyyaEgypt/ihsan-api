<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use JWTAuth;

class UserResource extends JsonResource
{
    private $user;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'token' => JWTAuth::fromUser($this->user)
        ];
    }

    /**
     * Setting Additional Data
     */
    public function setAdditionalData($user)
    {
        $this->user = $user;
    }
}
