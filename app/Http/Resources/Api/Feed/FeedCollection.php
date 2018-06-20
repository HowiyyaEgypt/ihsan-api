<?php

namespace App\Http\Resources\Api\Feed;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Api\Feed\FeedResource;

class FeedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'data' => FeedResource::collection($this->collection),
            'meta' => [
                'total_donated_meals' => \App\Meal::all()->count(),
                'total_delivered_meals' => \App\Delivery::all()->count(),
                'total_kitchens' => \App\Kitchen::all()->count(),
            ]
        ];
    }
}
