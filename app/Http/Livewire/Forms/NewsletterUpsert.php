<?php

namespace App\Http\Livewire\Forms;

use App\Models\Newsletter;
use Livewire\Component;

class NewsletterUpsert extends Component {
  public $method = 'POST';
  public $actionRoute = "newsletters.store";
  public $actionRouteParams = [];
  public $submitText = "Crea";
  public $cancelText = "Annulla";
  public int $newsletterId;
  public array $newsletter;
  public $listeners = ["change:send_asap" => "changeSendAsap"];
  
  public function mount() {
    $this->newsletter = Newsletter::find($this->newsletterId)->toArray();
    
    $this->newsletter["listId"] = "";
    $this->newsletter["send_asap"] = true;
    
  }
  
  public function render() {
    return view('livewire.forms.newsletter-upsert');
  }
  
  public function changeSendAsap($value) {
    $this->newsletter["send_asap"] = $value;
    $this->emit("change:model", $this->newsletter);
  }
  
}
