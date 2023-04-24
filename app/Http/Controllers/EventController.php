<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\UpsertEventRequest;
use App\Models\Event;
use App\Traits\WithAppOptions;
use App\Traits\WithCoverImg;
use App\View\Components\Tables\EventActions;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class EventController extends Controller {
  use WithAppOptions, WithCoverImg;
  
  /**
   * Create the controller instance.
   *
   * @return void
   */
  public function __construct() {
    // register the policy
    $this->authorizeResource(Event::class, 'event');
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(): View {
    $tableStructure = [
      ["title" => "Titolo", "key" => "title"],
      ["title" => "Data Inizio", "key" => "startAt", "value" => fn(Event $row) => (new Carbon($row->startAt))->setTimezone(Cookie::get("global-tz"))->format("d/m/Y H:i")],
      ["title" => "Prenotabile", "key" => "bookable", "value" => fn(Event $row) => $row->bookable ? "Si" : "No"],
      ["title" => "Posti", "key" => "seats", "value" => fn(Event $row) => $row->remainingSeats() . "/" . $row->seats],
      ["title" => "Stato", "key" => "active", "value" => fn(Event $row) => $row->active ? "Attivo" : "Non Attivo"],
      ["title" => "App", "key" => "apps", "value" => fn(Event $row) => implode(", ", $row->apps)],
      ["title" => "", "key" => "actions", "value" => fn(Event $row, $readonly) => (new EventActions($row, $readonly))->render()],
    ];
    
    return view("events.index", [
      "tableStructure" => $tableStructure,
      "futureEvents"   => Event::where("startAt", ">=", Carbon::now()->startOf("day"))->orderBy("startAt", "asc")->paginate(),
      "pastEvents"     => Event::where("startAt", "<", Carbon::now()->startOf("day"))->orderBy("startAt", "desc")->paginate()
    ]);
  }
  
  /**
   * Show the form for creating a new resource.
   *
   * @return View
   */
  public function create(): View {
    return view("events.create");
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  UpsertEventRequest  $request
   *
   * @return RedirectResponse
   */
  public function store(UpsertEventRequest $request): RedirectResponse {
    $data = $request->validated();
    
    $this->upsertCoverImg($request, $data, "events");
    
    $event            = new Event($data);
    $event->createdBy = auth()->id();
    
    $event->save();
    
    return redirect()->route("events.show", $event->_id);
  }
  
  /**
   * Display the specified resource.
   *
   * @param  Event  $event
   *
   * @return View
   */
  public function show(Event $event): View {
    return view("events.show", [
      "event" => $event
    ]);
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  Event  $event
   *
   * @return View
   */
  public function edit(Event $event): View {
    return view("events.edit", [
      "event" => $event
    ]);
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  UpsertEventRequest  $request
   * @param  Event               $event
   *
   * @return RedirectResponse
   */
  public function update(UpsertEventRequest $request, Event $event): RedirectResponse {
    $data = $request->validated();
    
    $this->upsertCoverImg($request, $data, "events", $event);
    
    $event->update($data);
    $event->save();
    
    return redirect()->route("events.show", $event->_id);
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  Event  $event
   *
   * @return RedirectResponse
   */
  public function destroy(Event $event): RedirectResponse {
    $this->deleteCoverImg($event->coverImg);
    $event->delete();
    
    return redirect()->route("events.index");
  }
}
