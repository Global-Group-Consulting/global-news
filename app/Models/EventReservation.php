<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Query\Builder;

/**
 * @property string      $eventId
 * @property string      $userId
 * @property string      $status
 * @property string      $companions // JSON
 * @property-read string $_id
 * @property-read string $created_at
 * @property-read string $updated_at
 *
 * @mixin Builder
 */
class EventReservation extends Model {
  use HasFactory;
  
  protected $fillable = [
    "eventId",
    "userId",
    "status",
    "companions",
  ];
  
  public function event() {
    return $this->belongsTo(Event::class, "eventId", "_id");
  }
  
  public function user() {
    return $this->belongsTo(User::class, "userId", "_id")
      ->select([
        "_id",
        "firstName",
        "lastName",
        "email",
        "role",
      ]);
  }
}
