<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventReservationController extends Controller {
  public function index(Event $event) {
    $reservations = $event->reservations()->with("user")->paginate();
    
    return response()->json($reservations);
  }
  
  public function store(Event $event, Request $request) {
    $data = $request->all();
    
    $reservation = $event->reservations()->create([
      "eventId"     => $event->_id,
      // Only admins can create reservations for other users
      "userId"     => $data["userId"],
      "status"     => "pending",
      "companions" => $data["companions"],
    ]);
    
    return response()->json($reservation);
  }
}
