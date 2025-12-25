<?php

namespace App\Http\Requests\V1;

use App\Enum\BloodGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DonorRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'contact' => ['required', 'string', 'max:255'],
      'division' => ['required', 'string', 'max:255'],
      'district' => ['required', 'string', 'max:255'],
      'sub_district' => ['required', 'string', 'max:255'],
      'address' => ['required', 'string', 'max:255'],
      'blood_group' => ['required', Rule::enum(BloodGroup::class)],
      'last_donation_date' => ['required', 'date'],
      'is_active' => ['required', 'boolean']
    ];
  }
}
