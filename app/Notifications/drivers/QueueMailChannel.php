<?php

namespace App\Notifications\drivers;

use App\Jobs\SendEmail;
use App\Models\App;
use App\Models\JobList;
use App\Models\User;
use App\Traits\BasicNotification;
use Illuminate\Notifications\Notification;

class QueueMailChannel {
  /**
   * Send the given notification.
   *
   * @param  mixed                           $notifiable
   * @param  Notification&BasicNotification  $notification
   *
   * @return void
   */
  public function send(User $notifiable, Notification $notification) {
    /**@var JobList $job */
    $job = JobList::where("class", "App\Jobs\SendEmail")->first();
    
    /** @var App $app */
    $app = App::where("code", $notification->data["app"])->first();
    
    /** @var mixed $email */
    $email = $notification->toQueueMail($notifiable);
    
    SendEmail::dispatch([
      "to"           => $notifiable->email,
      "from"         => $app->emailsFrom,
      "alias"        => $email["alias"],
      "templateData" => $email["data"],
    ])->onQueue($job->queueName);
  }
}
