<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventReservationUpsertRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    // only premium users or admins
    return false;
  }
  
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
    ];
  }
}
