<?php

namespace App\Http\Requests;

use App\Models\Newsletter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreNewsletterRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(Request $request) {
    return $request->user()->can('create', Newsletter::class);
  }
  
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      "subject" => "required|string",
      "content" => "required|string",
    ];
  }
}
