<?php

namespace App\View\Components\Forms;

use App\Models\Event;
use App\Traits\WithAppOptions;
use Illuminate\View\Component;

class EventsUpsert extends Component {
  use WithAppOptions;
  
  public array $appsOptions;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(public string $action, public string $method = "POST", public Event|null $event = null) {
    $this->appsOptions = $this->getAppsOptions();
    
    if ( !$this->event) {
      $this->event = new Event();
    }
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render() {
    return view('events.forms.upsert');
  }
}
