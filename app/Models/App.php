<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string                              code
 * @property string                              title
 * @property string                              description
 * @property array{client: mixed, server: mixed} secrets
 * @property string                              emailsFrom
 */
class App extends Model {
  use HasFactory;
  
  protected $connection = "mongodb_iam";
  
}
