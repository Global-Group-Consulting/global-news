<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Array_;

/**
 * @property int    $id
 * @property int    $list_id
 * @property string $subject
 * @property string $content
 * @property string $status
 * @property bool   $send_asap
 * @property string $scheduled_at        - When the newsletter is scheduled to be sent
 * @property string $last_attempt_at     - When the newsletter was last sent
 * @property string $last_attempt_result - The result of the last attempt
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
    "scheduled_at",
    "subject",
    "content",
  ];
  
  public function images(): array {
    return Str::matchAll('/(communicator\/wysiwyg(.*?)(?="))/', $this->content)->toArray();
  }
}
