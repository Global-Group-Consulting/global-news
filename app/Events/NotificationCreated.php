<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated {
  use Dispatchable, InteractsWithSockets, SerializesModels;
  
  /**
   * @var array
   */
  public array $notification;
  
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($notification) {
    $this->notification = $notification;
  }
  
  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
//  public function broadcastOn() {
//    return new PrivateChannel('channel-name');
//  }
}
