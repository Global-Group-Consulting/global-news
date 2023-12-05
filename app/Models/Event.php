<?php

namespace App\Models;

use App\Enums\EventReservationStatus;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Query\Builder;
use MongoDB\BSON\ObjectId;

/**
 * @property string        $title
 * @property string        $content
 * @property string        $city
 * @property string        $place
 * @property Date          $startAt
 * @property Date          $endAt
 * @property int           $seats
 * @property bool          $active
 * @property bool          $bookable
 * @property string[]      $apps
 * @property string        $coverImg
 * @property ObjectId      $createdBy
 * @property-read ObjectId $_id
 * @property-read string   $updated_at
 * @property-read string   $created_at
 *
 * @mixin Builder
 */
class Event extends Model {
  use HasFactory;
  
  protected $appends = [
    "coverImgUrl",
    "isPast"
  ];
  
  protected $fillable = [
    "title",
    "content",
    "startAt",
    "endAt",
    "seats",
    "active",
    "bookable",
    "apps",
    "coverImg",
    "city",
    "place"
  ];
  
  protected $casts = [
    "startAt" => "datetime"
  ];
  
  protected $dates = [
//    "startAt",
    "endAt",
  ];
  
  public function isPast(): bool | null {
    $dayStart = Carbon::now()->startOf("day");
    
    return $this->startAt?->isBefore($dayStart);
  }
  
  public function reservations() {
    return $this->hasMany(EventReservation::class, "eventId", "_id");
  }
  
  public function remainingSeats() {
    $reservations = $this->reservations()->where("status", EventReservationStatus::ACCEPTED)->get();
    $count        = $reservations->count();
    $companions   = $reservations->sum(fn($reservation) => count($reservation->companions));
    
    $total = $count + $companions;
    
    return $this->seats - $total;
  }
  
  protected function setCreatedByAttribute($value) {
    $this->attributes["createdBy"] = new ObjectId($value);
  }
  
  protected function setActiveAttribute($value) {
    $this->attributes["active"] = (bool) $value;
  }
  
  protected function setBookableAttribute($value) {
    $this->attributes["bookable"] = (bool) $value;
  }
  
  protected function setSeatsAttribute($value) {
    $this->attributes["seats"] = (int) $value;
  }
  
  protected function setStartAtAttribute($value) {
    $date = Carbon::parse($value, Cookie::get("global-tz"))->setTimezone('UTC');
    
    $this->attributes["startAt"] = $this->fromDateTime($date);
  }
  
  public function getIdAttribute($value = null) {
    return $value;
  }
  
  public function getIsPastAttribute($value = null) {
    return $this->isPast();
  }
  
  protected function getCoverImgUrlAttribute() {
    return $this->coverImg ? Storage::url($this->coverImg) : '';
  }
  
}
