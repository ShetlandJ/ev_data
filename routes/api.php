<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\CapacityController;
use App\Http\Controllers\Home\PetCabinController;
use App\Http\Controllers\Home\FindATripController;
use App\Http\Controllers\Home\CarAvailabilityController;
use App\Http\Controllers\Home\AccommodationAvailabilityController;
use App\Services\ScraperService;

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

Route::get('/scraper', 'App\Services\ScraperService@getChargers');
Route::get('/statuses/{id}', 'App\Services\ConnectorService@getConnector');
Route::post('/search', 'App\Services\ConnectorService@searchConnectors');