<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function store(Request $request) {
        $payload = $request->all();
        $user = auth()->user();

        $campaign = Campaign::create([
            'user_id'   =>  $user['id'],
            'name'  =>  $payload['campaignName'],
            'created_by'    =>  $user['name']
        ]);

        if($campaign) {
            return response()->json([
                'status'    =>  true,
                'campaign'  =>  $campaign->toArray()
            ]);
        }

        return response()->json([
            'status'    =>  false,
        ]);
    }

    public function all(Request $request) {
        $campaigns = Campaign::all();

        return response()->json([
            'status'    =>  true,
            'campaigns' =>  $campaigns
        ]);
    }

    public function getSingleCampaign(Request $request, $campaignId) {
        $campaign = Campaign::where('id', $campaignId)->with('rssTrackers')->first();
        return response()->json([
            'status'    =>  true,
            'campaign'  =>  $campaign
        ]);
    }

    public function deleteCampaign(Request $request) {
        $campaignId = $request->get('campaignId');

        $deletedCampaign = Campaign::destroy($campaignId);

        return response()->json([
            'status'    =>  true,
        ]);
    }
}
