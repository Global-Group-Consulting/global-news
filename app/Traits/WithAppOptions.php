<?php

namespace App\Traits;

use App\Models\App;

trait WithAppOptions {
  private function getAppsOptions(): array {
    $apps        = App::all();
    $appsOptions = [];
    
    foreach ($apps as $app) {
      $appsOptions[] = [
        "value" => $app->code,
        "text"  => $app->title
      ];
    }
    
    return $appsOptions;
  }
}
