<?php

namespace App\Http\Controllers\Api;

use App\Exports\EventAccessExport;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Event;
use App\Models\EventAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
      /*"startAt" => [
        "\$gte" => new Carbon("2023-04-10" )// Carbon::now()->startOf("day")
      ],*/
    ])
      ->orderBy("startAt", "desc")->get();
    
    return response()->json($toReturn);
  }
  
  public function show(Event $event){
    $data = $event->toArray();
    $data["remainingSeats"] = $event->remainingSeats();
    
    return response()->json($data);
  }
  
  public function exportAccesses(Event $event) {
    return Excel::download(new EventAccessExport($event), "partecipazioni_{$event->_id}.xlsx");
  }
}
