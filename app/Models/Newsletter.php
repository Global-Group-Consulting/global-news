<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property int    $id
 * @property int    $list_id
 * @property string $subject
 * @property string $content
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Model
 * @mixin Builder
 */
class Newsletter extends Model {
  use HasFactory;
  
  protected $connection = "mysql";
  
  protected $fillable = [
    "list_id",
    "subject",
    "content",
  ];
}
