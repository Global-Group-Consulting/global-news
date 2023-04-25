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
      "reservationId" => "nullable|string",
      "eventId"       => "required|string",
      "passCode"      => "required|string",
    ]);
    
    if ($request->has("reservationId")) {
      $reservation = EventReservation::where("_id", $data["reservationId"])->first();
    } else {
      $reservation = EventReservation::where("passCode", $data["passCode"])->first();
    }
    
    $errorMessage = null;
    
    if ( !$reservation) {
      $errorMessage = "Reservation not found";
    } elseif ($reservation->status !== EventReservationStatus::ACCEPTED) {
      $errorMessage = "Reservation not accepted";
    } elseif ($reservation->eventId->__tostring() !== $data["eventId"]) {
      $errorMessage = "Wrong event";
    } elseif ($reservation->passCode !== $data["passCode"]) {
      $errorMessage = "Invalid pass";
    }
    
    if ($errorMessage) {
      return response()->json(["error" => $errorMessage], 400);
    }
    
    $reservation->load("user");
    
    $reservation->registerAccess();
    
    return response()->json($reservation);
  }
}
