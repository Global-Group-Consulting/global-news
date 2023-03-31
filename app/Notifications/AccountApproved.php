<?php

namespace App\Notifications;

use App\Traits\BasicNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification {
  use Queueable, BasicNotification;
}
