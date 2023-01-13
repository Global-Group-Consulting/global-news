<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewsletterTableActions extends Component {
  
  public $row;
  public $columns;
  
  public function render() {
    return view('livewire.newsletter-table-actions');
  }
}
