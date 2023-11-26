<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
  return view('welcome');
});*/

Route::middleware("auth")->get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes([
  "register" => false,
  "reset"    => false,
  "confirm"  => false
]);

Route::middleware("auth")->resource("news", \App\Http\Controllers\NewsController::class);
Route::middleware("auth")->resource("events", \App\Http\Controllers\EventController::class);
Route::middleware("auth")->resource("notifications", \App\Http\Controllers\NotificationController::class);
Route::middleware("auth")->resource("faqs", \App\Http\Controllers\FaqController::class);

Route::get('/events/{event}/reservations/{reservation}/pass/{passCode}', [\App\Http\Controllers\EventReservationController::class, 'pass']);

