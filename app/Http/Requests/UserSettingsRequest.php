<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsRequest extends FormRequest
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
            'currentPassword' => ['required', 'string', 'min:8'], // Valida o campo de senha atual
            'settings' => ['required', 'array'], // Valida que 'settings' é um array
            'settings.twofa' => ['required', 'boolean'], // A primeira chave deve ser um booleano
            'settings.endSessionInact' => ['required', 'integer', 'min:5'], // A segunda chave deve ser um número inteiro
        ];
    }
}
