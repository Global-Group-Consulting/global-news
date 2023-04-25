<?php

namespace App\Console\Commands;

use App\Jobs\CreateNotification;
use Illuminate\Console\Command;

class JobDispatcher extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'test:dispatch';
  
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';
  
  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
  }
  
  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle() {
    CreateNotification::dispatch(base64_encode('{"type":"newMessage","title":"Nuovo messaggio da Stefania Conti Gallenti","content":"Hai ricevuto un nuovo messaggio per l\'ordine 63fe19ea586e7a19a7dcc33f.","action":{"text":"Vai ai messaggi!","link":"https://private.globalclub.it/finder?order=63fe19ea586e7a19a7dcc33f&message=63ff6dcf586e7a19a7de61f8"},"platforms":["app"],"receivers":[{"_id":"606888b352483a0020f99a5a","firstName":"Johanna","lastName":"Simmerle","email":"johsimm69@gmail.com"}],"extraData":{"multiReadBy":"63ff6dcf586e7a19a7de61f8"},"app":"club"}'));
    
    return 0;
  }
}
