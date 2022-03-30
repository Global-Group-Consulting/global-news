<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReadNotificationRequest;
use App\Http\Requests\StoreNotificationRequest;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;

class NotificationController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @param  Request  $request
   *
   * @return JsonResponse
   */
  public function index(Request $request): JsonResponse {
    $user = $request->user()->_id;
  
    // For some reason, using classic where doesn't work on subArray element so must use "whereRaw" instead
    $notifications = Notification::whereRaw([
      // User is a receiver
      "receivers._id"   => $user,
      // User is not in readings
      "readings.userId" => ["\$ne" => $user]
    ])->get();
  
    return response()->json($notifications);
  }
  
  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreNotificationRequest  $request
   *
   * @return Model
   */
  public function store(StoreNotificationRequest $request): Model {
    $data = $request->validated();
  
    return Notification::create($data);
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  ReadNotificationRequest  $request
   * @param  Notification             $notification
   *
   * @return JsonResponse
   */
  public function read(ReadNotificationRequest $request, Notification $notification): JsonResponse {
    $platform = $request->query("platform");
  
    $notification->setAsRead($request->user(), $platform);
  
    return response()->json($notification);
  }
}
