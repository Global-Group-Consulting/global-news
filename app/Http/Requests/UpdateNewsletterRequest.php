<?php

namespace App\Http\Requests;

use App\Models\Newsletter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateNewsletterRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(Request $request, Newsletter $newsletter): bool {
    return $request->user()->can('update', $newsletter);
  }
  
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      "subject"      => "required|string",
      "content"      => "required|string",
      "list_id"      => "required|exists:mysql.newsletter_lists,id",
      "scheduled_at" => "nullable|date",
      "send_asap"    => "nullable|boolean",
    ];
  }
}
