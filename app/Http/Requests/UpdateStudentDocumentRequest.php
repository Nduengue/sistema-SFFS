<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentDocumentRequest extends FormRequest
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
            'file' => [
                'required', // ou 'nullable' se a imagem for opcional
                'file', // Verifica se o arquivo é um arquivo
                'mimes:pdf', // Permite apenas arquivos do tipo PDF
                'max:2048', // Tamanho máximo do arquivo em kilobytes (2048 KB = 2 MB)
            ],
            'doc_type' => 'required|numeric|in:1,2'
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'The file is required.',
            'file.file' => 'The file must be a valid file.',
            'file.mimes' => 'The file must be a PDF file.',
            'file.max' => 'The file may not be greater than 2 MB.',
        ];
    }
}
