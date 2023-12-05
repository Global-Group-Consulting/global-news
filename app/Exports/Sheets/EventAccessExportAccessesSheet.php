<?php

namespace App\Exports\Sheets;

use App\Enums\UserRole;
use App\Models\Event;
use App\Models\EventAccess;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventAccessExportAccessesSheet implements FromArray, WithHeadings, WithColumnWidths, WithStyles, WithTitle {
  use Exportable;
  
  protected Event $event;
  protected Collection $accessList;
  
  public function __construct(Event $event, Collection $accessList) {
    $this->event      = $event;
    $this->accessList = $accessList;
  }
  
  public function headings(): array {
    return [
      [
        "Id prenotazione",
        "Id utente",
        "Nome",
        "Cognome",
        "Email",
        "Ruolo",
        "Referente",
        "Agente riferimento",
        "Data accesso",
        "Data prenotazione"
      ]
    ];
  }
  
  /**
   * @return \Illuminate\Support\Collection
   */
  public function array(): array {
    $list = $this->accessList;

//    dd($list);
    
    return $list->toArray();
  }
  
  public function columnWidths(): array {
    
    return [
      "A" => 25, // id prenotazione
      "B" => 25, // id utente
      "C" => 20, // nome
      "D" => 20, // cognome
      "E" => 25, // email
      "F" => 15, // data accesso
      "G" => 40, // data prenotazione
      "H" => 40, // ruolo
      "I" => 20, // referente
      "J" => 20, // agente riferimento
    ];
  }
  
  
  public function styles(Worksheet $sheet) {
    return [
      1 => [
        "font" => [
          "bold" => true,
          "size" => 14,
        ],
      ],
    ];
  }
  
  public function title(): string {
    return "Lista Presenti";
  }
}
