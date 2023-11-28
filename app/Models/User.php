<?php

namespace App\Models;

use App\Enums\AppType;
use App\Enums\NotificationType;
use App\Enums\PlatformType;
use App\Jobs\CreateNotification;
use App\Traits\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
  
  public function eventAccesses() {
    return $this->hasMany(EventAccess::class, "userId", "_id");
  }
  
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
  
  public function sendNotification(array $config, array $emailConfig): void {
    $validator = Validator::make($config, [
      "title"       => "required|string",
      "content"     => "required|string",
      "coverImg"    => "nullable|string",
      "type"        => ["required", Rule::in(NotificationType::ALL)],
      "platforms"   => "array|min:1",
      "platforms.*" => [Rule::in([PlatformType::APP, PlatformType::PUSH, PlatformType::EMAIL])],
      "action"      => "required|array",
      "action.text" => "required|string",
      "action.link" => "required|string",
    ]);
    
    $data = $validator->validate();
    
    $createNotificationConfig = JobList::where("class", "App\Jobs\CreateNotification")->first();
    
    CreateNotification::dispatch([
      "title"     => $data["title"],
      "content"   => $data["content"],
      "app"       => AppType::CLUB,
      "type"      => $data["type"],
      "platforms" => $data["platforms"],
      "receivers" => [$this->toArray()],
      "action"    => [
        "text" => $data["action"]["text"],
        "link" => $data["action"]["link"],
      ],
      "extraData" => [ // data for email
        "actionLink" => $data["action"]["link"],
        "user"       => $this->only(["firstName", "lastName", "email"]),
        ...$emailConfig
      ]
    ])->onQueue($createNotificationConfig->queueName);
  }
}
