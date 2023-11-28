<?php

namespace App\Exports;

use App\Enums\UserRole;
use App\Exports\Sheets\EventAccessExportAccessesSheet;
use App\Exports\Sheets\EventAccessExportDashboardSheet;
use App\Models\Event;
use App\Models\EventAccess;
use Cassandra\Type\UserType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventAccessExport implements WithMultipleSheets {
  use Exportable;
  
  protected Event $event;
  
  public function __construct(Event $event) {
    $this->event = $event;
  }
  
  /**
   * @return array
   */
  public function sheets(): array {
    $sheets = [];
    
    $list = $this->getAccessList();
    
    $sheets[] = new EventAccessExportDashboardSheet($this->event, $list);
    $sheets[] = new EventAccessExportAccessesSheet($this->event, $list);
    
    return $sheets;
  }
  
  private function getAccessList(): Collection {
    $accesses = EventAccess::query()
      ->where("eventId", $this->event->_id)
      ->orderBy("reservationId", "asc")
      ->orderBy("userId", "desc")
      ->get();
    
    $groupedByPassCode = $accesses->groupBy("passCode");
    
    return $groupedByPassCode->map(function ($access) {
      $firstAccess      = $access->first();
      $isCompanion      = !$firstAccess->userId;
      $reservationOwner = $firstAccess?->reservation?->user;
      $referenceAgent   = $reservationOwner?->refAgent;

//      $ownerIsAgent     = $reservationOwner?->role === UserRole::AGENT;
      
      return [
        "id_prenotazione"    => $firstAccess->reservationId,
        "id_utente"          => $firstAccess->userId,
        "nome"               => $firstAccess->firstName,
        "cognome"            => $firstAccess->lastName,
        "email"              => $firstAccess->email,
        "ruolo"              => !$isCompanion ? UserRole::LABELS[$reservationOwner?->role] : 'Ospite',
        "referente"          => $isCompanion ? $reservationOwner->firstName . " " . $reservationOwner->lastName . "($reservationOwner->_id)" : '',
        "agente_riferimento" => $referenceAgent ? $referenceAgent->firstName . " " . $referenceAgent->lastName . "($referenceAgent->_id)" : '',
        "data_accesso"       => $firstAccess->accessAt?->format("d/m/Y H:i:s"),
        "data_prenotazione"  => $firstAccess->reservation?->created_at->format("d/m/Y H:i:s"),
      ];
    })->values();
  }
}
