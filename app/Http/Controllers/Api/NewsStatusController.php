<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\UTCDateTime;

class NewsStatusController extends Controller {
  public function index() {
    /**
     * @var App $app
     */
    $app  = Session::get('app');
    $news = News::where("apps", $app["code"])->orderBy("created_at", "desc")->get();
    
    
    return response()->json($news);
  }
  
  /**
   * @param  string  $newsId
   *
   * @return JsonResponse
   */
  public function read(string $newsId): JsonResponse {
    $userId = Auth::id();
    $news   = News::findOrFail($newsId);
    
    if ( !$news->readStatuses) {
      $news->readStatuses = [];
    }
    
    $containsUser = in_array($userId, array_column($news->readStatuses, 'userId'));
    
    // add the read entry only if is not yet read
    if ( !$containsUser) {
      $news->push("readStatuses", [
        "userId"     => $userId,
        "created_at" => new UTCDateTime()
      ]);
    }
    
    return response()->json(["status" => "ok"]);
  }
}
