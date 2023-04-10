<?php

namespace App\Listeners;

use App\Enums\NotificationType;
use App\Enums\PlatformType;
use App\Events\NotificationCreated;
use App\Jobs\SendEmail;
use App\Models\User;
use App\Notifications\WpBritesToUnlock;
use App\Notifications\WpNewSemester;
use App\Notifications\NewMessage;
use App\Notifications\NewNews;
use App\Notifications\OrderUpdate;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use MongoDB\BSON\ObjectId;

class PropagateNotification {
  protected $availableQueues = [];
  
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct() {
//    $availableQueues = Queu;
  }
  
  /**f
   * Handle the event.
   *
   * @param  \App\Events\NotificationCreated  $event
   *
   * @return void
   * @throws Exception
   */
  public function handle(NotificationCreated $event) {
    /*
     * Quando una notifica viene creata, la propaga a tutti i destinatari
     * A seconda della tipologia, viene eseguito il dispatch della classe corretta
     */
    $receivers = $event->notification["receivers"];
    
    foreach ($receivers as $receiver) {
      $this->dispatchNotification($event->notification, $receiver);
    }
  }
  
  /**
   * @throws Exception
   */
  private function dispatchNotification($notification, $receiver) {
    $user                     = User::where("_id", $receiver["_id"])->first();
    $notification["receiver"] = $receiver;
    $className                = Str::ucfirst(Str::camel($notification["type"]));
    
    // gestisce il caso il cui l'id sia volutamente null ma ci sia un email o un numero di telefono
    if ($receiver["_id"] === null) {
      $user      = new User($receiver);
      $user->_id = new ObjectId($receiver["_id"]);
    }
    
    if ( !$user) {
      $user = User::findOrFail($receiver);
    }
    
    try {
      $specificFileExists = file_exists(app_path("Notifications/$className.php"));
      
      // By default, use PolymorphicNotification class if the specific one doesn't exist
      if ( !$specificFileExists) {
        $className = "PolymorphicNotification";
      }
      
      $class = '\App\Notifications\\' . $className;
      
      // dynamically import the right class.
      Notification::send($user, new $class($notification));
    } catch (Exception $e) {
      throw new Exception("Notification type not found: " . $notification["type"] . " with name $className");
    }
  }
  
}
