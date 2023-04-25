<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component {
  
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(public string|null $sizeClasses = null,
                              public string|null $title = null,
                              public bool        $includeBackBtn = true,
                              public string      $backUrl = "") {
    //
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public
  function render() {
    return view('components.card');
  }
}
