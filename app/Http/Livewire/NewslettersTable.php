<?php

namespace App\Http\Livewire;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class NewslettersTable extends Component {
  public string $pagination;
  public array $columns = [
    [
      "label" => "ID",
      "name"  => "id",
    ],
    [
      "label" => "Oggetto",
      "name"  => "subject",
    ],
    [
      "label" => "Stato",
      "name"  => "status",
    ],
    [
      "label" => "Data creazione",
      "name" => "created_at",
      "type" => "datetime",
    ],
    [
      "label" => "",
      "type" => "livewire",
      "component" => "newsletter-table-actions",
    ],
  ];
  
  public function mount(LengthAwarePaginator $newsletters) {
    $this->data = $newsletters->items();
    $this->pagination = $newsletters->links();
  }
  
  public function render() {
    return view('livewire.newsletters-table');
  }
}
