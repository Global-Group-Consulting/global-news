<?php

namespace App\Models;

use App\Enums\AppType;
use App\Enums\NotificationType;
use App\Enums\PlatformType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string           $_id
 * @property string           $title
 * @property string           $content
 * @property string           $coverImg
 * @property AppType          $app       app where to show the notification
 * @property NotificationType $type      type of the notification
 * @property PlatformType[]   $platforms array of platforms will be used to show the notification
 * @property array            $receivers list of users id that must receive the notification
 * @property array            $readings  list of all readings for the notification
 * @property bool             $completed must be true if all receivers has read the notification.
 * @property Date             $created_at
 * @property Date             $updated_at
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin Builder
 */
class Notification extends Model {
  use HasFactory;
  
  /**
   * @var string[]
   */
  protected $fillable = ["title", "content", "coverImg", "app", "type", "receivers", "platforms"];
  
  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'completed' => false,
    'readings'  => [],
    'platforms' => [PlatformType::APP]
  ];
  
  protected function getReadingsAttribute($value): \Illuminate\Support\Collection {
    return collect($value);
  }
  
  protected function getReceiversAttribute($value): \Illuminate\Support\Collection {
    return collect($value);
  }
  
  public function setAsRead(User $user, $platform) {
    /**
     * @var Collection $readings
     */
    $readings = $this->readings;
    $contains = $readings->contains("userId", $user->_id);
    
    if ( !$contains) {
      $readings->push(new NotificationReading([
        "userId"   => $user->_id,
        "platform" => $platform
      ]));
    }
    
    $this->readings = $readings->toArray();
    $this->save();
  }
}
