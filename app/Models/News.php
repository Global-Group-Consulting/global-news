<?php

namespace App\Models;

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
 * @property bool          $active
 * @property string[]      $apps
 * @property string        $coverImg
 * @property ObjectId      $createdBy
 * @property-read ObjectId $_id
 * @property-read string   $updated_at
 * @property-read string   $created_at
 *
 * @mixin Builder
 */
class News extends Model {
  use HasFactory;
  
  protected $fillable = ["title", "content", "startAt", "endAt", "coverImg",
    "attachments", "createdBy", "active", "apps"];
  
  /*protected $casts = [
    'active' => 'boolean',
  ];*/
}
