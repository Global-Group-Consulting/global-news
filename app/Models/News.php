<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class News extends Model {
  use HasFactory;
  
  protected $fillable = ["title", "content", "startAt", "endAt", "coverImg",
    "attachments", "createdBy", "active", "apps"];
  
  /*protected $casts = [
    'active' => 'boolean',
  ];*/
}
