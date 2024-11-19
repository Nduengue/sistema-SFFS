<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateProfilePasswordRequest extends FormRequest
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
            'currentPassword' => 'sometimes|required|max:50|min:8',
            'newPassword' => [
                'required',
                'max:50',
                'min:8',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#%@!$&*])[A-Za-z\d#%@!$&*]{8,20}$/',
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();
            // Verifica se a senha atual está correta
            if (!Hash::check($this->currentPassword, $user->password)) {
                $validator->errors()->add('currentPassword', 'A senha atual está incorreta.');
            } else {
                // Se a senha atual estiver correta, verifica se a nova senha é diferente da senha atual
                if (Hash::check($this->newPassword, $user->password)) {
                    $validator->errors()->add('newPassword', 'A nova senha não pode ser a mesma que a senha atual.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'newPassword.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, one special character (#%@!$&*), and be between 8 and 20 characters long.',
        ];
    }
}
