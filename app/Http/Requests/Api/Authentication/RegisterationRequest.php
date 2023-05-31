<?php

namespace App\Http\Requests\Api\Authentication;

use App\Helpers\HandlesValidationResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterationRequest extends FormRequest
{
    use HandlesValidationResponse;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required|min:5|max:100',
            'email' => 'string|required|email|unique:users,email',
            'phone' => 'string|required|unique:users,phone|regex:/^01[0125][0-9]{8}$/',
            'password' => [
                'string', 'required', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(), 'confirmed'
            ]
        ];
    }
   
}
