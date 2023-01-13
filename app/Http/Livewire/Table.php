<?php

namespace App\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Table extends Component {
  public array $data;
  public string $pagination;
  public array $columns = [];
  
  public function mount($columns) {
    $this->columns = array_map(function ($column) {
      return [
        ...$column,
        "type" => $column["type"] ?? "text",
      ];
    }, $columns);
    
  }
  
  public function render() {
    return view('livewire.table');
  }
  
}
