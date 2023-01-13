<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormInput extends Component {
  public $subject;
  public $name;
  public $label;
  public $type;
  public $value;
  
  public function render() {
    return view('livewire.form-input');
  }
}
