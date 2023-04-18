<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Query\Builder;
use MongoDB\BSON\ObjectId;

/**
 * @property string        $title
 * @property string        $content
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
  ];
  
  protected $dates = [
    "startAt",
    "endAt",
  ];
  
  public function isPast(): bool {
    $dayStart = Carbon::now()->startOf("day");
    
    return $this->startAt->isBefore($dayStart);
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
}
