<?php

namespace App\Http\Requests;

use App\Enums\PlatformType;
use App\Models\Notification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReadNotificationRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    //    $notification = $this->route("notification");
  
    // Allow access only if the user is a receiver
    //    return $notification->receivers->contains("_id", $this->user()->_id);
    return true;
  }
  
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      "platform" => ['required', Rule::in([PlatformType::APP, PlatformType::EMAIL, PlatformType::PUSH])],
    ];
  }
}
