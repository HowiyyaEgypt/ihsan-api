<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Feed;
use App\Http\Resources\Api\Feed\FeedResource;
use App\Http\Resources\Api\Feed\FeedCollection;
use App\Services\APIAuthTrait;


class FeedController extends Controller
{
    use APIAuthTrait;

    public function latestFeeds(Request $request)
    {
        $user = $this->APIAuthenticate();
        
        // the organization assosc. with the user
        $organizations_ids = $user->organizations->pluck('id')->toArray();

        // the users whom the user is following
        $following_ids = $user->following->pluck('id')->toArray();

        $feeds = Feed::where(function($q1) use ($organizations_ids) {
            $q1->where('feedable_type', 'App\Organization')->whereIn('feedable_id', $organizations_ids);
        })
        ->orWhere(function($q2) use ($following_ids) {
            $q2->where('feedable_type', 'App\User')->whereIn('feedable_id', $following_ids);
        })
        ->orderBy('created_at','DESC')->get();

        $feed_resource = (new FeedCollection($feeds))->additional(['success' => true, 'message' => 'Tracking has been retrived']);

        return $feed_resource->response()->setStatusCode(200);
    }
}
