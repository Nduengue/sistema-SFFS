<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePhotoRequest extends FormRequest
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
            'profileImage' => [
                'sometimes',
                'required', // ou 'nullable' se a imagem for opcional
                'image', // Verifica se o arquivo é uma imagem (jpeg, png, bmp, gif, svg, webp)
                'mimes:jpeg,png,jpg,gif', // Tipos MIME permitidos
                'max:2048', // Tamanho máximo do arquivo em kilobytes (2048 KB = 2 MB)
                'dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000', // Restrições de dimensões (opcional)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'profileImage.required' => 'The profile image is required.',
            'profileImage.image' => 'The file must be a valid image (jpeg, png, bmp, gif, svg, webp).',
            'profileImage.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            'profileImage.max' => 'The profile image may not be greater than 2 MB.',
            'profileImage.dimensions' => 'The profile image must be at least 100x100 pixels and at most 3000x3000 pixels.',
        ];
    }
}
