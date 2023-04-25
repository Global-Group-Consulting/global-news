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
    "accessAt",
  ];
  
  protected $dates = [
    "accessAt",
  ];
  
  public function eventReservation() {
    return $this->belongsTo(EventReservation::class, "reservationId", "_id");
  }
}
