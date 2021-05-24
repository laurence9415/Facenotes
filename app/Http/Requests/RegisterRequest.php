<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', Rule::unique('users')->ignore($this->user)],
            'password' => [Rule::requiredIf(!isset($this->user)), 'confirmed', 'min:6'],
            'phone_number' => ['required', 'string', 'max:15'],
            'mobile_number' => ['required', 'string', 'max:15'],
            'address' => ['required', 'min:3'],
            'city' => ['required', 'string', 'min:3', 'max:50'],
            'state' => ['required', 'string', 'min:3', 'max:50'],
            'zip_code' => ['required', 'string', 'max:20'],
            'profile_picture' => [Rule::requiredIf(!isset($this->user)), 'image'],
        ];
    }
}
