<?php

namespace App\Http\Controllers\QrPass;

use App\Enums\EventReservationStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller {
  public function index() {
    $data = Event::where("startAt", ">=", Carbon::now()->startOf("day"))->orderBy("startAt", "asc")->get();
    
    return response()->json($data);
  }
  
  public function check(Request $request) {
    $data = Validator::validate($request->all(), [
      "eventId"       => "required|string",
      "passCode"      => "required|string",
    ]);
    
    $reservation = EventReservation::where(function ($q) use ($data) {
        $q->where("passCode", $data["passCode"])
          ->orWhere("companions.passCode", $data["passCode"]);
      })
      ->first();
    
//    if ($request->has("reservationId")) {
//      $reservation = EventReservation::where("_id", $data["reservationId"])->first();
//    } else {
//      $reservation = EventReservation::where("passCode", $data["passCode"])->first();
//    }
    
    $errorMessage = null;
    
    if ( !$reservation) {
      $errorMessage = "Reservation not found";
    } elseif ($reservation->status !== EventReservationStatus::ACCEPTED) {
      $errorMessage = "Reservation not accepted";
    } elseif ($reservation->eventId->__tostring() !== $data["eventId"]) {
      $errorMessage = "Wrong event";
    } /*elseif ($reservation->passCode !== $data["passCode"]) {
      $errorMessage = "Invalid pass";
    }*/
    
    $userPass = $reservation->passCode !== $data["passCode"]
      ? collect($reservation->companions)->firstWhere("passCode", $data["passCode"])
      : [
        "firstName" => $reservation->user->firstName,
        "lastName"  => $reservation->user->lastName,
        "email"     => $reservation->user->email,
        "passCode"  => $reservation->passCode,
        "userId"    => $reservation->userId,
      ];
    
    if ($errorMessage) {
      return response()->json(["error" => $errorMessage], 400);
    }
    
    $reservation->load("user");
    
    $reservation->registerAccess($userPass);
    
    return response()->json($reservation);
  }
}
