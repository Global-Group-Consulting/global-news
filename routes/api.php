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

Route::post("/testNotification", function (\Illuminate\Http\Request $request) {
  $data = $request->all();
  $user = \App\Models\User::first();
  
  \App\Jobs\CreateNotification::dispatch($data)->onQueue("staging.notifications");
  //  $user->notify(new \App\Notifications\NewMessage($data));

//  \Illuminate\Support\Facades\Notification::send($user, new \App\Notifications\NewMessage($data));
  
  
  return $data;
});

Route::middleware('auth.customToken')
  ->namespace("\App\Http\Controllers\Api")
  ->prefix("events")
  ->group(function () {
    
    Route::get('/', "EventController@index");
    Route::get('/{event}', "EventController@show");
    Route::get('/{event}/reservations', "EventReservationController@index");
    Route::POST('/{event}/reservations', "EventReservationController@store");
  });

Route::middleware('auth.customToken')
  ->namespace("\App\Http\Controllers\Api")
  ->prefix("news")
  ->group(function () {
    
    Route::get('/', "NewsStatusController@index");
    Route::patch('/{news}/read', "NewsStatusController@read");
  });

Route::middleware('auth.customToken')
  ->namespace("\App\Http\Controllers\Api")
  ->prefix("notifications")
  ->group(function () {
  
    Route::get('/', "NotificationController@index");
    Route::get('/counters', "NotificationController@counters");
    
    /*Route::post('/', "NotificationController@store")
      ->withoutMiddleware("auth.customToken")
      ->middleware("auth.cronUser");*/
    Route::patch('/all/read', "NotificationController@readAll");
    Route::patch('/{notification}/read', "NotificationController@read");
    Route::patch('/{notification}/readByContent', "NotificationController@readByContent");
    Route::patch('/{notification}/unread', "NotificationController@unread");
  });

Route::middleware('auth.customToken')
  ->namespace("\App\Http\Controllers\Api")
  ->prefix("faqs")
  ->group(function () {
    
    Route::get('/', "FaqController@index");
//    Route::patch('/{faqs}/read', "NewsStatusController@read");
  });
