<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormSwitch extends Component {
  public $subject;
  public $name;
  public $label;
  public $type;
  public $checked;
  
  public function render() {
    return view('livewire.form-switch');
  }
  
  public function onChange() {
    $this->checked = $this->checked === "1";
    
    $this->emit("change:{$this->name}", $this->checked);
  }
}
