<?php

namespace App\Http\Controllers\Api;

use App\Enums\EventReservationStatus;
use App\Enums\NotificationType;
use App\Enums\PlatformType;
use App\Http\Controllers\Controller;
use App\Jobs\CreateNotification;
use App\Models\Event;
use App\Models\EventReservation;
use App\Notifications\EventReservationUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use MongoDB\BSON\ObjectId;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
    
    $counters["remainingSeats"] = $event->remainingSeats();
    
    return response()->json($counters);
  }
  
  public function updateStatus(Event $event, EventReservation $reservation, Request $request) {
    $data = $request->validate([
      "status" => ["required", Rule::in([EventReservationStatus::ACCEPTED, EventReservationStatus::REJECTED, EventReservationStatus::PENDING])],
    ]);
    
    $requiredSeats  = count($reservation->companions) + 1;
    $remainingSeats = $event->remainingSeats();
    
    if ($data["status"] === EventReservationStatus::ACCEPTED) {
      if ($requiredSeats > 1 && $remainingSeats < $requiredSeats) {
        throw new BadRequestHttpException("Sono stati richiesti $requiredSeats posti, ma ce ne sono disponibili solo $remainingSeats, pertanto non è possibile accettare la prenotazione.");
      } elseif (!$remainingSeats) {
        throw new BadRequestHttpException("Non ci sono più posti disponibili, pertanto non è possibile accettare la prenotazione.");
      }
    }
    
    $reservation->update([
      "status"          => $data["status"],
      "statusUpdatedAt" => now(),
    ]);
    
    if ($data["status"] === EventReservationStatus::ACCEPTED) {
      // if the reservation is accepted, we must generate the pass, upload it to the cloud and add passUrl to the reservation
      $reservation->passCode = uniqid(null);
      $reservation->passQr   = $this->generatePass($reservation);
    } else {
      $this->destroyPass($reservation);
      $reservation->passCode = null;
      $reservation->passQr   = null;
    }
    
    $reservation->save();
    
    if ($data["status"] === EventReservationStatus::ACCEPTED) {
      $this->sendPassEmail($reservation, $event);
    }
    
    return $reservation;
  }
  
  public function statusNotify(Event $event, EventReservation $reservation) {
    $this->sendPassEmail($reservation, $event);
  }
  
  public function generatePass(EventReservation $reservation): string {
    $data = [
      "reservationId" => $reservation->_id->__toString(),
      "eventId"       => $reservation->eventId->__toString(),
      "passCode"      => $reservation->passCode,
    ];
    
    $qrCode = QrCode::encoding('UTF-8')
      ->size(400)
      ->style('round')
      ->eye('circle')
      ->margin(3)
      ->format("svg")
      ->generate(json_encode($data));
    
    $fileName = Str::uuid() . ".svg";
    $path     = "events/{$reservation->eventId}/passes/$fileName";
    
    Storage::put($path, $qrCode, "public");
    
    return $path;
  }
  
  public function destroyPass(EventReservation $reservation) {
    if ( !$reservation->passQr) {
      return;
    }
    
    Storage::delete($reservation->passQr);
  }
  
  public function sendPassEmail(EventReservation $reservation, Event $event) {
    if ( !$reservation->passUrl) {
      Log::log("error", "Pass url not found for reservation {$reservation->_id->__toString()}");
      return;
    }
    
    $reservation->user->sendNotification([
      "title"     => "Richiesta di partecipazione accettata",
      "content"   => "La richiesta di partecipazione all'evento ”{$event->title}” è stata accettata",
      "coverImg"  => "nullable|string",
      "type"      => NotificationType::EVENT_RESERVATION_UPDATE,
      "platforms" => [PlatformType::APP, PlatformType::PUSH, PlatformType::EMAIL],
      "action"    => [
        "text" => "Visualizza il pass",
        "link" => $reservation->passUrl,
      ],
    ], [
      "eventName" => $event->title,
      "status"    => __("enums.EventReservationStatus.{$reservation->status}", [], "it"),
      "accepted"  => $reservation->status === EventReservationStatus::ACCEPTED,
    ]);
  }
}
