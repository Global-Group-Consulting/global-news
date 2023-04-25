<?php

namespace App\Models;

use App\Enums\EventReservationStatus;
use \Illuminate\Support\Env;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Query\Builder;
use MongoDB\BSON\ObjectId;

/**
 * @property string      $eventId
 * @property string      $userId
 * @property string      $status
 * @property array       $companions  // JSON
 * @property string      $passCode    // unique code generated on approval
 * @property string      $passQr      // qr code generated on approval
 * @property string      $passUrl     // qr code generated on approval
 * @property-read string $_id
 * @property-read string $created_at
 * @property-read string $updated_at
 *
 * @mixin Builder
 */
class EventReservation extends Model {
  use HasFactory;
  
  protected $appends = [
    "passUrl",
  ];
  
  protected $fillable = [
    "eventId",
    "userId",
    "status",
    "statusUpdatedAt",
    "companions",
  ];
  
  protected $dates = [
    "statusUpdatedAt",
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
  
  public function accesses() {
    return $this->hasMany(EventAccess::class, "reservationId", "_id");
  }
  
  public function setUserIdAttribute($value) {
    $this->attributes["userId"] = new ObjectId($value);
  }
  
  public function setEventIdAttribute($value) {
    $this->attributes["eventId"] = new ObjectId($value);
  }
  
  public function getIdAttribute($value = null) {
    return $value;
  }
  
  public function getPassUrlAttribute() {
    if ($this->status !== EventReservationStatus::ACCEPTED) {
      return null;
    }
    
    return Env::get("APP_URL") . "/events/" . $this->eventId . "/reservations/" . $this->_id . "/pass";
  }
  
  public function registerAccess() {
    $this->accesses()->create([
      "eventId"  => $this->eventId,
      "userId"   => $this->userId,
      "accessAt" => now(),
    ]);
  }
}
