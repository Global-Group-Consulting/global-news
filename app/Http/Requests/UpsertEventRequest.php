<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;

class UpsertEventRequest extends FormRequest {
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
      "title"    => "required|string",
      "content"  => "required|string",
      "startAt"  => "required|date",
      //"endAt"    => "required|date",
      "seats"    => "required|int",
      "active"   => "boolean",
      "bookable" => "boolean",
      "apps"     => "required",
      "coverImg" => ["image", ($this->routeIs("events.update") ? "nullable" : "required")]
    ];
  }
}
