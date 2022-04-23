<?php

namespace App\Providers;

use App\Models\App;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthServiceProvider extends ServiceProvider {
  /**
   * The policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
  ];
  
  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot() {
    $this->registerPolicies();
    
    /*Auth::viaRequest('custom-token', function (Request $request) {
      $headers  = $request->headers;
      $authUser = $request->get("_auth_user");
  
      if ( !$headers->has('client-secret') || !$headers->has('server-secret') || !$authUser) {
        throw new AccessDeniedHttpException("Unauthorized - Missing secrets");
      }
  
      // cerca sia il client secret che il severe secret per assicurarsi che combaciano
      $apps = App::where("secrets.client.secretKey", $headers->get('client-secret'))
        ->orWhere("secrets.server.secretKey", $headers->get('server-secret'))
        ->get();
  
      $isSameApp = false;
  
      if ($apps->count() === 1) {
        $app         = $apps[0];
        $clientMatch = $app->secrets["client"]["secretKey"] === $headers->get('client-secret');
        $serverMatch = $app->secrets["server"]["secretKey"] === $headers->get('server-secret');
    
        $isSameApp = $clientMatch || $serverMatch;
      }
  
      if ($apps->count() !== 2 && !$isSameApp) {
        throw new AccessDeniedHttpException("Unauthorized - Invalid secrets");
      }
  
      $reqApp = null;
  
      foreach ($apps as $app) {
        if ($app["secrets"]["client"]["secretKey"] === $headers->get('client-secret')) {
          $reqApp = $app;
        }
      }
  
      // Store in session the app where the request has come
      Session::put('app', $reqApp);
  
      return User::find($authUser["_id"]);
    });*/
  }
}
