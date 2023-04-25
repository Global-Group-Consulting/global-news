<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Mocode\Sanctum\HasApiTokens;

class CronUser extends Authenticatable {
  use HasFactory, HasApiTokens;
  
  protected $connection = "mongodb_legacy";
  
}
