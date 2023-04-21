<?php

namespace App\Http\Controllers\Api;

use App\Enums\EventReservationStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use MongoDB\BSON\ObjectId;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EventReservationController extends Controller {
  public function index(Event $event, Request $request) {
    $status = $request->get("status");
    $query  = $event->reservations();
    
    if ($status) {
      $query->where("status", $status);
    }
    
    $reservations = $query->with("user")
      ->orderBy("created_at", "asc")->paginate();
    
    return response()->json($reservations);
  }
  
  public function upsert(Event $event, Request $request) {
    $data   = $request->all();
    $userId = $request->has("userId") ? $data["userId"] : Auth::user()->_id;
//    $authUser = Auth::user();
//    $userId = Auth::user()->_id;
//    return $authUser->isAdmin();
    
    // if no reservation id is provided, we are adding a new reservation
    // so we must check if the user has already a reservation for this event
    // if so, block it
    if ( !$request->has("reservationId")) {
      $userReservation = $event->reservations()->where("userId", new ObjectId($userId))->first();
      $remainingSeats  = $event->remainingSeats();
      
      if ($userReservation) {
        throw new BadRequestHttpException("L'utente ha già una prenotazione per questo evento.");
      }
      
      if ( !$remainingSeats) {
        throw new BadRequestHttpException("Non ci sono più posti disponibili.");
      }
    }
    
    $reservation = $event->reservations()->updateOrCreate([
      "userId"  => new ObjectId($userId),
      "eventId" => new ObjectId($event->_id),
    ], [
      "eventId"    => $event->_id,
      // Only admins can create reservations for other users
      "userId"     => $userId,
      "status"     => EventReservationStatus::PENDING,
      "companions" => $data["companions"],
    ]);
    
    return response()->json($reservation);
  }
  
  public function counters(Event $event) {
    $counters = EventReservation::raw()->aggregate([
      [
        "\$match" => [
          "eventId" => $event->_id,
        ]
      ],
      [
        "\$group" => [
          "_id"   => [
            "status" => '$status',
          ],
          "count" => [
            '$sum' => 1,
          ],
        ]
      ]
    ])->toArray();
    
    
    $counters = collect($counters)->mapWithKeys(function ($item) {
      return [$item["_id"]["status"] => $item["count"]];
    })->toArray();
    
    return response()->json($counters);
  }
  
  public function updateStatus(Event $event, EventReservation $reservation, Request $request) {
    $data = $request->validate([
      "status" => ["required", Rule::in([EventReservationStatus::ACCEPTED, EventReservationStatus::REJECTED, EventReservationStatus::PENDING])],
    ]);
    
    if ( !$event->remainingSeats() && $data["status"] === EventReservationStatus::ACCEPTED) {
      throw new BadRequestHttpException("Non ci sono più posti disponibili, pertanto non è possibile accettare la prenotazione.");
    }
    
    $reservation->update([
      "status"          => $data["status"],
      "statusUpdatedAt" => now(),
    ]);
    
    $reservation->save();
    
    return $reservation;
  }
}
