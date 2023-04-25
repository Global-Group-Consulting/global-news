<?php

use App\Enums\EventReservationStatus;

return [
  "EventReservationStatus" => [
    EventReservationStatus::PENDING                => 'In attesa',
    EventReservationStatus::PENDING . '_infinito'  => 'mettere In Attesa',
    EventReservationStatus::PENDING . '_azione'    => 'metti In Attesa',
    EventReservationStatus::PENDING . '_passato'   => 'rimessa In Attesa',
    EventReservationStatus::ACCEPTED               => 'Approvata',
    EventReservationStatus::ACCEPTED . '_infinito' => 'Approvare',
    EventReservationStatus::ACCEPTED . '_azione'   => 'Approva',
    EventReservationStatus::ACCEPTED . '_passato'  => 'Approvata',
    EventReservationStatus::REJECTED               => 'Rifiutata',
    EventReservationStatus::REJECTED . '_infinito' => 'Rifiutare',
    EventReservationStatus::REJECTED . '_azione'   => 'Rifiuta',
    EventReservationStatus::REJECTED . '_passato'  => 'Rifiutata'
  ]
];
