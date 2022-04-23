<?php

namespace App\Http\Requests;

use App\Enums\AppType;
use App\Enums\NotificationType;
use App\Enums\PlatformType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotificationRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }
  
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      "title"                 => "required|string",
      "content"               => "required|string",
      "coverImg"              => "nullable|string",
      "app"                   => ['required', Rule::in([AppType::MAIN, AppType::CLUB, AppType::NEWS])],
      "type"                  => ["required", Rule::in([NotificationType::NEW_MESSAGE, NotificationType::NEW_NEWS, NotificationType::ORDER_UPDATE])],
      "platforms"             => "array|min:1",
      "platforms.*"           => [Rule::in([PlatformType::APP, PlatformType::PUSH, PlatformType::EMAIL])],
      "receivers"             => "required|array|min:1",
      "receivers.*._id"       => "required|string",
      "receivers.*.firstName" => "required|string",
      "receivers.*.lastName"  => "required|string",
      "receivers.*.email"     => "required|email",
      "action"                => "required|array",
      "action.text"           => "required|string",
      "action.link"           => "required|string",
      "extraData"             => "nullable|array",
    ];
  }
}
