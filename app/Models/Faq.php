<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int     $id
 * @property string  $question
 * @property string  $answer
 * @property string  $apps
 * @property string  $author
 * @property boolean $active
 * @property string  $updated_at
 * @property string  $created_at
 */
class Faq extends Model {
  use HasFactory;
  
  protected $connection = 'mysql';
  
  protected $fillable = ["question", "answer", "apps", "active"];
  
  protected $casts = [
    'apps' => 'array'
  ];
}
