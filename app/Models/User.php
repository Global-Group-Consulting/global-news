<?php

namespace App\Models;

use App\Enums\AppType;
use App\Enums\PlatformType;
use App\Traits\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string _id
 */
class User extends Authenticatable {
  use HasApiTokens, HasFactory, Notifiable, HybridRelations;
  
  protected $connection = "mongodb_legacy";
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'firstName',
    'lastName',
    'email',
    'password',
  ];
  
  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];
  
  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
  
  /**
   * @param  string<PlatformType>  $platform
   * @param  string<AppType>       $app
   * @param  bool                  $paginated
   * @param  bool                  $onlyCounters
   *
   * @return Collection | PaginatedResourceResponse
   */
  public function unreadNotificationsByPlatform(string $platform, string $app, bool $paginated = false, bool $onlyCounters = false) {
    $data = $this->notifications()->unread()
      ->where(["data.platforms" => $platform,
               "data.app"       => $app]);
    
    if ($paginated) {
      return $data->paginate();
    } elseif ($onlyCounters) {
      return $data->count();
    }
    
    return $data->get();
  }
  
  
  /**
   * @param  string<PlatformType>  $platform
   * @param  string<AppType>       $app
   * @param  bool                  $paginated
   *
   * @return Collection | PaginatedResourceResponse
   */
  public function readNotificationsByPlatform(string $platform, string $app, bool $paginated = false, bool $onlyCounters = false) {
    $data = $this->notifications()->read()
      ->where(["data.platforms" => $platform,
               "data.app"       => $app]);
    
    if ($paginated) {
      return $data->paginate();
    } elseif ($onlyCounters) {
      return $data->count();
    }
    
    return $data->get();
  }
  
  public function isAdmin() {
    $roles = collect($this->roles);
    
    return $roles->has(["admin", "super_admin"]);
  }
}
