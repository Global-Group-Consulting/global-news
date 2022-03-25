<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class NotificationController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(): View {
    $notifications = Notification::paginate();
    
    return view("notifications.index", compact("notifications"));
  }
  
  /**
   * Show the form for creating a new resource.
   *
   * @return View
   */
  public function create(): View {
    return view("notifications.create");
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return Response
   */
  public function store(Request $request) {
    //
  }
  
  /**
   * Show the form for editing the specified resource.
   *
   * @param  Notification  $notification
   *
   * @return Response
   */
  public function edit(Notification $notification) {
    //
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Notification              $notification
   *
   * @return Response
   */
  public function update(Request $request, Notification $notification) {
    //
  }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param  Notification  $notification
   *
   * @return Response
   */
  public function destroy(Notification $notification) {
    //
  }
}
