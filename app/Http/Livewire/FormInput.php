<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormInput extends Component {
  public $subject;
  public $name;
  public $label;
  public $type;
  public $value;
  public $model;
  public $formData;
  public $disabled;
  public $accept;
  
  public $listeners = ["change:model" => "changeModel"];
  
  public function mount() {
  
  }
  
  public
  function render() {
    return view('livewire.form-input');
  }
  
  public function changeModel($model) {
    $this->formData = $model;
  }
}
