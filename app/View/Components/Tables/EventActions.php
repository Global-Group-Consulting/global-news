<?php

namespace App\View\Components\Tables;

use App\Models\Event;
use Illuminate\View\Component;

class EventActions extends Component {
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(public Event $event,
                              public bool  $readonly = false) {
    //
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render() {
    return view('events.tables.actions', [
      "event" => $this->event,
      "readonly" => $this->readonly
    ]);
  }
}
