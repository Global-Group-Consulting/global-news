<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\EventAccess;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventAccessExport implements FromArray, WithHeadings, WithColumnWidths {
  use Exportable;
  
  protected Event $event;
  
  public function __construct(Event $event) {
    $this->event = $event;
  }
  
  public function headings(): array {
    return [
      ["Evento:", $this->event->title . "(" . $this->event->_id . ")"],
      ["Luogo:", $this->event->place . "(" . $this->event->city . ")"],
      ["Data:", $this->event->startAt->format("d/m/Y H:i:s")],
      [],
      [
        "Id prenotazione",
        "Id utente",
        "Nome",
        "Cognome",
        "Email",
        "Data accesso",
        "Data prenotazione",
      ]
    ];
  }
  
  
  /**
   * @return \Illuminate\Support\Collection
   */
  public function array(): array {
    $accesses = EventAccess::query()
      ->where("eventId", $this->event->_id)
      ->with("user", function ($query) {
        $query->select("_id", "name", "surname", "email");
      })
      ->with("reservation")
      ->get();
    
    /*
     * Ospiti
     * utenti
     * agenti
     * agente x -> ospiti
     * agente x -> agenti
     * agente x -> clienti
     */
    
    $data = $accesses->map(function ($access) {
      return [
        "Id prenotazione"   => $access->reservation?->_id->__toString(),
        "Id utente"         => $access->userId,
        "Nome"              => $access->user?->firstName,
        "Cognome"           => $access->user?->lastName,
        "Email"             => $access->user?->email,
        "Data accesso"      => $access->accessAt?->format("d/m/Y H:i:s"),
        "Data prenotazione" => $access->reservation?->created_at->format("d/m/Y H:i:s"),
      ];
    });

    dd($data);
    
    return $data->toArray();
  }
  
  public function columnWidths(): array {
    
    return [
      "A" => 25, // id prenotazione
      "B" => 25, // id utente
      "C" => 20, // nome
      "D" => 20, // cognome
      "E" => 25, // email
      "F" => 20, // data accesso
      "G" => 20, // data prenotazione
    ];
  }
  
}
