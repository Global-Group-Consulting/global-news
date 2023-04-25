<?php

namespace App\Http\Controllers\CronAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller {
  public function login(Request $request) {
    $token = $request->user()->createToken($request->user()->username, $request->user()->apps);
    
    return ['token' => $token->plainTextToken];
  }
}
