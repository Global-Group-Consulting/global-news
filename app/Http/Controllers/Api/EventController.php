<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller {
  public function index() {
    $userId = Auth::id();
    /**
     * @var App $app
     */
    $app = Session::get('app');
    
    $toReturn = Event::where([
      "apps"    => $app["code"],
      "active"  => true,
      "startAt" => [
        "\$gte" => Carbon::now()->startOf("day")
      ],
    ])
      ->orderBy("startAt", "asc")->get();
    
    return response()->json($toReturn);
  }
  
  public function show(Event $event){
    return response()->json($event);
  }
}
