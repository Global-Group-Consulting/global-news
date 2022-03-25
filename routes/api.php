<?php

use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:api')
  ->namespace("\App\Http\Controllers\Api")
  ->prefix("news")
  ->group(function () {
    
    Route::get('/', "NewsStatusController@index");
    Route::patch('/{news}/read', "NewsStatusController@read");
    
  });

Route::middleware('auth:api')
  ->namespace("\App\Http\Controllers\Api")
  ->prefix("notifications")
  ->group(function () {
    
    Route::get('/', "NotificationController@index");
    Route::post('/', "NotificationController@store");
    Route::patch('/{notification}/read', "NotificationController@read");
    
  });

