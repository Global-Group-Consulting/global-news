<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property-read  int $id
 * @property string    $name
 * @property string    $user_ids
 * @property string    $roles
 *
 * @mixin Model
 * @mixin Builder
 */
class NewsletterList extends Model {
  use HasFactory;
  
  protected $connection = "mysql";
  
  protected $fillable = [
    "name",
    "user_ids",
    "roles",
  ];
  
  public function newsletters(): \Illuminate\Database\Eloquent\Relations\HasMany {
    return $this->belongsTo(Newsletter::class);
  }
}
