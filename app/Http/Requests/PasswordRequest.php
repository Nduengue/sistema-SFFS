<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   
        if(Auth::user()){return true;}
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oldPassword' => 'sometimes|required|max:50|min:8',
            'newPassword' => 'required|max:50|min:8', [
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#%@!$&*])[A-Za-z\d#%@!$&*]{8,20}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'newPassword.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, one special character (#%@!$&*), and be between 8 and 20 characters long.',
        ];
    }

}
