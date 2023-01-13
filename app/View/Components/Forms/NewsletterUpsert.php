<?php

namespace App\View\Components\Forms;

use App\Models\Newsletter;
use Illuminate\View\Component;

class NewsletterUpsert extends Component {
  public string $method = "POST";
  public string $actionRoute = "";
  public Newsletter $newsletter;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($method = 'POST', $actionRoute = null, $newsletter = null) {
    $this->method      = $method;
    $this->actionRoute = $actionRoute ?? "newsletters.store";
    $this->newsletter  = $newsletter;
    
    // TODO::// fare una variabile dove inseriscco i dati del newsletter, sia old che newsletter.
    // lato view, limitarmi solo a stampare le varie voci senza controllare da dove prendere i dati
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render() {
    return view('components.forms.newsletter_upsert');
  }
}
