<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormTextEditor extends Component {
  public $subject;
  public $name;
  public $label;
  public $value;
  
  public function render() {
    return view('livewire.form-text-editor');
  }
}
