<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Table extends Component {
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(public array                           $structure,
                              public Collection|LengthAwarePaginator $items,
                              public bool                            $readonly = false) {
    //
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render() {
    return view('components.table');
  }
}
