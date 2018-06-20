<?php

namespace App\Http\Resources\Api\Feed;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FeedResource extends JsonResource
{
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
            'message_ar' => $this->full_message['body']['ar'],
            'message_en' => $this->full_message['body']['en'],
            'date' => $this->created_at->diffForHumans()
        ];
    }
}
