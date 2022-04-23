<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\JobListController
 *
 * @mixin Builder
 * @property int                             $id
 * @property string                          $title
 * @property string                          $description
 * @property string                          $class
 * @property string                          $payloadValidation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string                          $payloadKey
 * @property string|null                     $apiUrl
 * @property string|null                     $apiMethod
 * @property string|null                     $apiHeaders
 * @property string|null                     $authType
 * @property string|null                     $authUsername
 * @property string|null                     $authPassword
 * @property string                          $queueName
 * @method static Builder|JobList newModelQuery()
 * @method static Builder|JobList newQuery()
 * @method static Builder|JobList query()
 * @method static Builder|JobList whereApiHeaders($value)
 * @method static Builder|JobList whereApiMethod($value)
 * @method static Builder|JobList whereApiUrl($value)
 * @method static Builder|JobList whereClass($value)
 * @method static Builder|JobList whereCreatedAt($value)
 * @method static Builder|JobList whereDescription($value)
 * @method static Builder|JobList whereId($value)
 * @method static Builder|JobList wherePayloadKey($value)
 * @method static Builder|JobList wherePayloadValidation($value)
 * @method static Builder|JobList whereTitle($value)
 * @method static Builder|JobList whereUpdatedAt($value)
 */
class JobList extends Model {
  use HasFactory;
  
  protected $connection = 'mysql';
  
  protected $fillable = [
    "title",
    "description",
    "class",
    "queueName",
    "payloadKey",
    "payloadValidation",
    "apiUrl",
    "apiMethod",
    "apiHeaders",
    "authType",
    "authPassword",
    "authUsername",
  ];
  
  protected $payloadKey;
}
