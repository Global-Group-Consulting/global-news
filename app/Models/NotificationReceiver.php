<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $_id
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 */
class NotificationReceiver extends Model {
  use HasFactory;
  
  protected $fillable = ["_id", "firstName", "lastName", "email"];
}
