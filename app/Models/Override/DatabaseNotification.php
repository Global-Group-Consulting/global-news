<?php

namespace App\Models\Override;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Jenssegers\Mongodb\Eloquent\Model;

class DatabaseNotification extends Model {
  
  /**
   * The "type" of the primary key ID.
   *
   * @var string
   */
//  protected $keyType = 'string';
  
  protected $primaryKey = '_id';
  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;
  
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'notifications';
  
  /**
   * The guarded attributes on the model.
   *
   * @var array
   */
  protected $guarded = [];
  
  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'read_at' => 'datetime',
  ];
  
  /**
   * Get the notifiable entity that the notification belongs to.
   *
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function notifiable() {
    return $this->morphTo();
  }
  
  /**
   * Mark the notification as read.
   *
   * @return void
   */
  public function markAsRead($platform) {
    if (is_null($this->read_at)) {
      $this->forceFill(['read_at'   => $this->freshTimestamp(),
                        'read_from' => $platform])->save();
    }
  }
  
  /**
   * Mark the notification as unread.
   *
   * @return void
   */
  public function markAsUnread() {
    if ( !is_null($this->read_at)) {
      $this->forceFill(['read_at'   => null,
                        'read_from' => null])->save();
    }
  }
  
  /**
   * Determine if a notification has been read.
   *
   * @return bool
   */
  public function read() {
    return $this->read_at !== null;
  }
  
  /**
   * Determine if a notification has not been read.
   *
   * @return bool
   */
  public function unread() {
    return $this->read_at === null;
  }
  
  /**
   * Scope a query to only include read notifications.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeRead(Builder $query) {
    return $query->whereNotNull('read_at');
  }
  
  /**
   * Scope a query to only include unread notifications.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   *
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeUnread(Builder $query) {
    return $query->whereNull('read_at');
  }
  
  /**
   * Create a new database notification collection instance.
   *
   * @param  array  $models
   *
   * @return \Illuminate\Notifications\DatabaseNotificationCollection
   */
  public function newCollection(array $models = []) {
    return new DatabaseNotificationCollection($models);
  }
  
  public function setDataAttribute($value) {
    $this->attributes['data'] = is_string($value) ? json_decode($value) : $value;
  }
  
}

