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

Route::post("/sendNotification", function (){
  (\App\Models\User::query()->first())->sendNotification([
    "title"     => "Richiesta di partecipazione accettata",
    "content"   => "La richiesta di partecipazione all'evento è stata accettata",
    "coverImg"  => "nullable|string",
    "type"      => \App\Enums\NotificationType::EVENT_RESERVATION_UPDATE,
    "platforms" => [\App\Enums\PlatformType::APP, \App\Enums\PlatformType::PUSH, \App\Enums\PlatformType::EMAIL],
    "action"    => [
      "text" => "Visualizza il pass",
      "link" => "asdaasdasd",
    ],
  ], [
    "eventName" => "titolo evento",
    "status"    => __("enums.EventReservationStatus.accepted", [], "it"),
    "accepted"  => true,
  ]);
});

Route::middleware('auth.customToken')
  ->namespace("\App\Http\Controllers\Api")
  ->prefix("events")
  ->group(function () {
    
    Route::get('/', "EventController@index");
    Route::get('/{event}', "EventController@show");
    Route::get('/{event}/reservations', "EventReservationController@index");
    Route::get('/{event}/reservations/counters', "EventReservationController@counters");
    Route::post('/{event}/reservations', "EventReservationController@upsert");
    Route::patch('/{event}/reservations/{reservation}/status', "EventReservationController@updateStatus");
    Route::post('/{event}/reservations/{reservation}/statusNotify/{passCode}', "EventReservationController@statusNotify");
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

Route::namespace("\App\Http\Controllers\CronAuth")
  ->group(function () {
    Route::post("/login", "AuthenticationController@login")
      ->middleware("auth.cronUser");
  });

Route::namespace("\App\Http\Controllers\QrPass")
  ->middleware('auth:sanctum')
  ->prefix("qrpass")
  ->group(function () {
    Route::get("/events", "EventController@index");
    Route::post("/check", "EventController@check");
  });
