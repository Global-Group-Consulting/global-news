<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendEmail implements ShouldQueue {
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
  /**
   * @var array{from: string, alias: string, to: string, subject: string, templateData: array }
   */
  protected $data;
  
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($data) {
    $this->data = $data;
  }
  
  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle() {
    Log::log("info", "sending email in modo sbagliato", $this->data);
    // Handled by Queues App
  }
}
