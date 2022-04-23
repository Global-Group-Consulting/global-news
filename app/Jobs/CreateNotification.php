<?php

namespace App\Jobs;

use App\Events\NotificationCreated;
use App\Http\Requests\StoreNotificationRequest;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateNotification implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
  /**
   * Store incoming notification data.
   *
   * @var mixed $data
   */
  protected $data;
  
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($incomingData) {
    $this->data = $incomingData;
  }
  
  /**
   * @return array
   */
  public function get_data(): array {
    $toReturn = [];
    
    if (gettype($this->data) === "string") {
      try {
        $toReturn = json_decode(base64_decode($this->data), true);
      } catch (\Exception $er) {
        var_dump($er);
      }
    } elseif (is_array($this->data)) {
      $toReturn = $this->data;
    }
    
    return $toReturn;
  }
  
  /**
   * Execute the job.
   *
   * @return void
   * @throws ValidationException
   */
  public function handle() {
    $data = $this->get_data();
    $rules     = (new StoreNotificationRequest())->rules();
    $validator = Validator::make($data, $rules);
    
    if ($validator->fails()) {
      throw new \Exception("Invalid data: " . $validator->errors()->toJson());
    }
    
    NotificationCreated::dispatch($validator->validated());
  }
}
