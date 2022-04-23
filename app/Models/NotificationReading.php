<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Date;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;

/**
 * @property string $_id
 * @property string $userId
 * @property string platform On what platform did the user read the notification (push, email, app)
 * @property Date   $created_at
 * @property Date   $updated_at
 */
class NotificationReading extends Model {
  use HasFactory;
  
  protected $fillable = ["userId", "platform"];
  
  public function __construct(array $attributes = []) {
    parent::__construct($attributes);
    
    $this->_id        = new ObjectId();
    $this->created_at = now();
    $this->updated_at = now();
  }
  
}
