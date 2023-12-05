<?php

namespace App\Exports\Sheets;

use App\Enums\UserRole;
use App\Models\Event;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventAccessExportDashboardSheet implements WithTitle, WithHeadings, FromArray, WithColumnWidths, WithStyles {
  use Exportable;
  
  protected Event $event;
  protected Collection $accessList;
  
  public function __construct(Event $event, Collection $accessList) {
    $this->event      = $event;
    $this->accessList = $accessList;
  }
  
  public function headings(): array {
    return [
      ["Evento:", $this->event->title . "(" . $this->event->_id . ")"],
      ["Luogo:", $this->event->place . "(" . $this->event->city . ")"],
      ["Data:", $this->event->startAt->format("d/m/Y H:i:s")],
      [],
    ];
  }
  
  /**
   * @return string
   */
  public function title(): string {
    return "Resoconto";
  }
  
  /**
   * @return array
   */
  public function array(): array {
    /*
     * Ospiti
     * utenti
     * agenti
     * agente x -> ospiti
     * agente x -> agenti
     * agente x -> clienti
     */
    $conteggiPerRuolo  = $this->accessList->countBy("ruolo");
    $conteggiPerAgente = $this->accessList->groupBy(["agente_riferimento", "ruolo"])->map(function ($item) {
      return $item->map(function ($item) {
        return $item->count();
      });
    });

//    dd($conteggiPerAgente);
    
    $toReturn = [
      [""],
      $conteggiPerRuolo->map(function ($item, $key) {
        return $key;
      }),
      $conteggiPerRuolo,
      [""],
      ...$conteggiPerAgente->map(function ($item, $nomeAgente) {
        if ( !$nomeAgente) {
          $nomeAgente = "Senza agente";
        }
        
        $toReturn = [[$nomeAgente]];
        
        $item->each(function ($item, $key) use (&$toReturn) {
          $toReturn[] = ["", $key, $item];
        });
        
        $toReturn[] = [""];
        
        return $toReturn;
      }),
    ];
    
//    dd($toReturn);
    
    return $toReturn;
  }
  
  public function columnWidths(): array {
    return [
      "A" => 25,
      "B" => 25,
      "C" => 25,
    ];
  }
  
  public function styles(Worksheet $sheet) {
    $sheet->mergeCells("B1:D1");
    $sheet->mergeCells("B2:D2");
    $sheet->mergeCells("B3:D3");
    
    return [
      "A1" => [
        "font" => [
          "bold" => true,
        ],
      ],
      "A2" => [
        "font" => [
          "bold" => true,
        ],
      ],
      "A3" => [
        "font" => [
          "bold" => true,
        ],
      ],
    ];
  }
}
