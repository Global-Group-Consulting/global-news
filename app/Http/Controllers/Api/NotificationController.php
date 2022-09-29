<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReadNotificationRequest;
use App\Http\Requests\StoreNotificationRequest;
use App\Jobs\SendEmail;
use App\Models\Job;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
    /**
     * @var User $user
     */
    $user     = $request->user();
    $platform = $request->input("platform");
    $app      = $request->input("app");
    $showRead = $request->input("read", false);
    
    if ($showRead) {
      $notifications = $user->readNotificationsByPlatform($platform, $app, true);
    } else {
      $notifications = $user->unreadNotificationsByPlatform($platform, $app, true);
    }
    
    return response()->json($notifications);
  }
  
  /**
   * Display a listing of the resource.
   *
   * @param  Request  $request
   *
   * @return JsonResponse
   */
  public function counters(Request $request): JsonResponse {
    /**
     * @var User $user
     */
    $user     = $request->user();
    $platform = $request->input("platform");
    $app      = $request->input("app");
    
    $result = [
      "unread" => $user->unreadNotificationsByPlatform($platform, $app, false, true),
      "read"   => $user->readNotificationsByPlatform($platform, $app, false, true)
    ];
    
    return response()->json($result);
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  ReadNotificationRequest  $request
   * @param  string                   $notification
   *
   * @return Response
   */
  public function read(ReadNotificationRequest $request, $notificationId): Response {
    $platform = $request->query("platform");
    $app      = $request->input("app");
    
    /**
     * @var $user User
     */
    $user              = $request->user();
    $notifications     = $user->unreadNotificationsByPlatform($platform, $app);
    $foundNotification = false;
    
    foreach ($notifications as $notification) {
      if ($notification->id == $notificationId) {
        $notification->markAsRead($platform);
        $foundNotification = true;
      }
    }
    
    return response($foundNotification ? "OK" : "NOT_FOUND_OR_ALREADY_READ");
  }
  
  /**
   * Update the specified resource in storage based on the extraData prop multiReadBy
   *
   * @param  ReadNotificationRequest  $request
   * @param  string                   $multiReadBy
   *
   * @return Response
   */
  public function readByContent(ReadNotificationRequest $request, $multiReadBy): Response {
    $platform = $request->query("platform");
    $app      = $request->input("app");
    
    /**
     * @var $user User
     */
    $user              = $request->user();
    $notifications     = $user->unreadNotificationsByPlatform($platform, $app);
    $foundNotification = false;
    
    
    foreach ($notifications as $notification) {
      $extraData = key_exists("extraData", $notification->data) ? $notification->data["extraData"] : null;
      
      if ($extraData && key_exists("multiReadBy", $extraData) && $extraData["multiReadBy"] == $multiReadBy) {
        $notification->markAsRead($platform);
        $foundNotification = true;
      }
    }
    
    return response($foundNotification ? "OK" : "NOT_FOUND_OR_ALREADY_READ");
  }
  
  public function readAll(ReadNotificationRequest $request): JsonResponse {
    $platform = $request->query("platform");
    $app      = $request->input("app");
    
    /**
     * @var $user User
     */
    $user = $request->user();
    
    $notifications = $user->unreadNotificationsByPlatform($platform, $app);
    
    foreach ($notifications as $notification) {
      $notification->markAsRead($platform);
    }
    
    return response()->json("OK");
  }
  
  /**
   * Update the specified resource in storage.
   *
   * @param  ReadNotificationRequest  $request
   * @param  string                   $notification
   *
   * @return Response
   */
  public function unread(ReadNotificationRequest $request, $notificationId): Response {
    $platform = $request->query("platform");
    $app      = $request->input("app");
    
    /**
     * @var $user User
     */
    $user              = $request->user();
    $notifications     = $user->readNotificationsByPlatform($platform, $app);
    $foundNotification = false;
    
    foreach ($notifications as $notification) {
      if ($notification->id == $notificationId) {
        $notification->markAsUnread($platform);
        $foundNotification = true;
      }
    }
    
    return response($foundNotification ? "OK" : "NOT_FOUND_OR_ALREADY_READ");
  }
  
}
