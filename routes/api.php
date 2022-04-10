<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\CampaignController;
use \App\Http\Controllers\RssTrackerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'campaign',
], function ($router){
    Route::post('create', [CampaignController::class, 'store']);
    Route::get('all', [CampaignController::class, 'all']);
    Route::get('{campaignId}/trackers', [CampaignController::class, 'getSingleCampaign']);
    Route::post('delete', [CampaignController::class, 'deleteCampaign']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'rss-track',
], function ($router){
    Route::post('create', [RssTrackerController::class, 'store']);
    Route::get('all', [RssTrackerController::class, 'all']);
//    Route::get('campaign/:campaignId', [CampaignController::class])
});

Route::group([
    'middleware'    =>  'auth:api',
    'prefix'    =>  'reader',
], function ($router) {
    Route::post('read', [RssTrackerController::class, 'readFeed']);
});

