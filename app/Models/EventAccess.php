<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Query\Builder;

/**
 * @mixin Builder
 */
class EventAccess extends Model {
  use HasFactory;
  
  protected $fillable = [
    "reservationId",
    "eventId",
    "userId",
    "firstName",
    "lastName",
    "email",
    "passCode",
    "accessAt",
  ];
  
  protected $dates = [
    "accessAt",
  ];
  
  public function reservation() {
    return $this->belongsTo(EventReservation::class, "reservationId", "_id");
  }
  
  public function user() {
    return $this->belongsTo(User::class, "userId", "_id");
  }
  
  public function event() {
    return $this->belongsTo(Event::class, "eventId", "_id");
  }
}
