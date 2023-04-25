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
  public function pass(Event $event, EventReservation $reservation) {
    if ($reservation->eventId != $event->_id) {
      throw new BadRequestHttpException("Prenotazione non trovata.");
    }
    
    if ($reservation->status !== EventReservationStatus::ACCEPTED) {
      throw new BadRequestHttpException("La prenotazione non è stata accettata.");
    }
    
    $pass = Storage::get($reservation->passQr);
    
    $reservation->load("user");
    
    return view("events.reservations.pass", compact("pass", "event", "reservation"));
  }
}
