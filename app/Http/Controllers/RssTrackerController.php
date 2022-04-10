<?php

namespace App\Http\Controllers;

use App\Events\NotifySlack;
use App\Jobs\ProcessRss;
use App\Models\RssTracker;
use Illuminate\Http\Request;
use Vedmant\FeedReader\Facades\FeedReader;


class RssTrackerController extends Controller
{
    public function store(Request $request) {
        $payload = $request->all();

        $rssTracker = RssTracker::create([
            'campaign_id'   =>  $payload['campaignId'],
            'name'  =>  'default',  // $payload['rssName']
            'configuration'    =>  json_encode($payload['configuration'])
        ]);


        event(new NotifySlack("Incoming"));
        ProcessRss::dispatch($rssTracker)->delay(now()->addSecond(10));


        if($rssTracker) {
            return response()->json([
                'status'    =>  true,
                'rssTracker'  =>  $rssTracker->toArray()
            ]);
        }

        return response()->json([
            'status'    =>  false,
        ]);
    }

    public function readFeed(Request $request) {
        $payload = $request->all();

        $feedArray = [];

        $feed = FeedReader::read($payload['rssLink']);

        foreach ($feed->get_items(0,5) as $item) {
            array_push($feedArray, $item->get_link());
        }

        return response()->json([
            'status'    =>  true,
            'feed'  =>  $feedArray
        ]);
    }
}
