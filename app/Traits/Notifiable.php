<?php

namespace App\Traits;


use App\Models\Override\DatabaseNotification;
use App\Models\Override\MultiConnectionDatabaseNotification;
use Jenssegers\Mongodb\Eloquent\Builder;

trait Notifiable {
  use \Illuminate\Notifications\Notifiable {
    \Illuminate\Notifications\Notifiable::notifications as baseNotificationsMethod;
  }
  
  public function notifications() {
    if (config('database.default') === 'mongodb') {
      return $this->morphMany(DatabaseNotification::class, 'notifiable')
        ->orderBy('created_at', 'desc');
    }
    
    return $this->baseNotificationsMethod();
  }
  
  
  
}
