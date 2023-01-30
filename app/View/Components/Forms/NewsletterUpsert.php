<?php

namespace App\View\Components\Forms;

use App\Models\Newsletter;
use Illuminate\View\Component;

class NewsletterUpsert extends Component {
  public Newsletter|null $newsletter;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(public $method = 'POST',
                              public $actionRoute = "newsletters.store",
                              public $actionRouteParams = [],
                              public $submitText = "Crea", public $cancelText = "Annulla",
                                     $newsletter = null,
  ) {
    $this->newsletter = $newsletter ?? $this->createFakeNewsletter();
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render() {
    return view('components.forms.newsletter_upsert');
  }
  
  private function createFakeNewsletter() {
    $newsletter             = new Newsletter();
    $newsletter->subject    = old('subject');
    $newsletter->content    = old('content');
    $newsletter->created_at = now();
    $newsletter->updated_at = now();
    
    return $newsletter;
  }
}
