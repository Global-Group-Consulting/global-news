<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use MongoDB\BSON\UTCDateTime;

class NewsStatusController extends Controller {
  public function index() {
    $userId = Auth::id();
    /**
     * @var App $app
     */
    $app  = Session::get('app');
    $news = News::where([
      "apps"   => $app["code"],
      "active" => true,
      "readStatuses.userId" => ["\$ne" => $userId]
    ])
      ->orderBy("created_at", "desc")->get();
  
    return response()->json(array_map(function ($singleNews) {
      $singleNews["coverImg"] = key_exists("coverImg", $singleNews) ? Storage::temporaryUrl($singleNews["coverImg"], now()->addMinutes(5)) : '';
    
      return $singleNews;
    }, $news->toArray()));
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
