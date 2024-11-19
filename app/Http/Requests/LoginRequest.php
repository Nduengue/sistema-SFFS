<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
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
            'email' => 'required|max:50|min:5|email',
            'password' => 'required|max:50|min:6',
            'code' => 'sometimes|required|digits:6',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strip_tags($this->email),
            'password' => strip_tags($this->password),
            //'code' => $this->has('code') ? preg_replace('/\D/', '', $this->code) : null,
        ]);
    }

}
