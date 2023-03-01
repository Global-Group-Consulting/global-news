<?php

namespace App\Traits;

use App\Enums\PlatformType;
use App\Jobs\SendEmail;
use App\Models\User;
use App\Notifications\drivers\QueueMailChannel;
use Illuminate\Support\Str;

trait BasicNotification {
  /**
   * @var array
   */
  public array $data;
  
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($data) {
    $this->data = $data;
  }
  
  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   *
   * @return array
   */
  public function via($notifiable): array {
    //TODO:: must check user notification settings and decide if propagate or not
    
    $platforms = $this->data["platforms"];
    $viaToUse  = [];
  
    foreach ($platforms as $platform) {
      switch ($platform) {
        case PlatformType::EMAIL:
          $viaToUse[] = QueueMailChannel::class;
          
          // If app is not specified, push anyway to database
          if ( !in_array(PlatformType::APP, $platforms)) {
            $viaToUse[] = 'database';
          }
          
          break;
        case PlatformType::APP:
        case PlatformType::PUSH:
          $viaToUse[] = "database";
          break;
      }
    }
    
    return collect($viaToUse)->unique()->toArray();
  }
  
  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   *
   * @return array{alias: string, data: array}
   */
  public function toQueueMail($notifiable): array {
    $className        = get_class($this);
    $notificationName = substr($className, strrpos($className, "\\", -1) + 1);
    $notificationName = Str::kebab($notificationName);
    $alias            = [$this->data["app"], $notificationName];
    $data             = key_exists("extraData", $this->data) ? $this->data["extraData"] : [];
  
    if (key_exists("action", $this->data)) {
      $data["action"] = $this->data["action"];
    }
    // check if $notifiable is an instance of User
    if ($notifiable instanceof User) {
      $data["receiver"] = [
        "id"        => $notifiable->id,
        "email"     => $notifiable->email,
        "firstName" => $notifiable->firstName,
        "lastName"  => $notifiable->lastName,
      ];
    }
  
    return [
      "alias" => join("-", $alias),
      "data"  => $data,
    ];
  }
  
  /**
   * Get the array representation of the notification.
   *
   * @param $user
   *
   * @return array
   */
  public function toArray($user): array {
    return $this->data;
  }
}
