<?php

namespace App\Http\Controllers;

use App\Enums\EventReservationStatus;
use App\Models\Event;
use App\Models\EventReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MongoDB\BSON\ObjectId;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EventReservationController extends Controller {
  public function pass(Event $event, EventReservation $reservation, $passCode) {
    if ($reservation->eventId != $event->_id) {
      throw new BadRequestHttpException("Prenotazione non trovata.");
    }
    
    if ($reservation->status !== EventReservationStatus::ACCEPTED) {
      throw new BadRequestHttpException("La prenotazione non è stata accettata.");
    }
    
    // search the reservation with the provided passCode
    $user = null;
    
    if ($reservation->passCode === $passCode) {
      $userReservation = [
        "isCompanion" => false,
        "firstName"   => $reservation->user->firstName,
        "lastName"    => $reservation->user->lastName,
        "email"       => $reservation->user->email,
        "passCode"    => $reservation->passCode,
        "passQr"      => $reservation->passQr,
        "passUrl"     => $reservation->passUrl,
      ];
    } else {
      // search inside companions
      $userReservation = collect($reservation->companions)->first(function ($item) use ($passCode) {
        return $item["passCode"] === $passCode;
      });
      
      if ($userReservation) {
        $userReservation["isCompanion"] = true;
      }
    }
    
    if ( !$userReservation) {
      throw new BadRequestHttpException("Codice pass non trovato.");
    }
    
    $passQr = Storage::get($userReservation["passQr"]);
    
    return view("events.reservations.pass", compact("passQr", "event", "reservation", "userReservation"));
  }
}
