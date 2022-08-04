<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FaqController extends Controller {
  
  /**
   * @return JsonResponse
   */
  public function index(): JsonResponse {
    /**
     * @var App $app
     */
    $app = Session::get('app');

    $faqs = Faq::where([
      "active" => true,
    ])
      ->whereJsonContains("apps", "club")
      ->orderBy("question", "asc")
      ->get();
    
    return response()->json($faqs->toArray());
  }
}
