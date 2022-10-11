<?php

namespace App\Listeners;

use App\Enums\NotificationType;
use App\Enums\PlatformType;
use App\Events\NotificationCreated;
use App\Jobs\SendEmail;
use App\Models\User;
use App\Notifications\WPBritesToUnlock;
use App\Notifications\WPNewSemester;
use App\Notifications\NewMessage;
use App\Notifications\NewNews;
use App\Notifications\OrderUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
   * @throws \Exception
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
  
  private function dispatchNotification($notification, $receiver) {
    $user = User::find($receiver);
    
    $notification["receiver"] = $receiver;
  
    switch ($notification["type"]) {
      case NotificationType::ORDER_UPDATE:
        Notification::send($user, new OrderUpdate($notification));
        break;
      case NotificationType::NEW_NEWS:
        Notification::send($user, new NewNews($notification));
        break;
      case NotificationType::NEW_MESSAGE:
        Notification::send($user, new NewMessage($notification));
        break;
      case NotificationType::WP_NEW_SEMESTER:
        Notification::send($user, new WPNewSemester($notification));
        break;
      case NotificationType::WP_BRITES_TO_UNLOCK:
        Notification::send($user, new WPBritesToUnlock($notification));
        break;
      default:
        throw new \Exception("Notification type not found");
    }
  }
  
}
