<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Validation\Rule;

class StoreStudentDocumentRequest extends FormRequest
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
        $id = $this->route('id'); // Captura o user_id da rota

        return [
            'user_id' => 'required|exists:students,user_id',
            'doc_type' => 'required|in:1,2',
            'file' => [
                'required', // ou 'nullable' se a imagem for opcional
                'file', // Verifica se o arquivo é um arquivo
                'mimes:pdf', // Permite apenas arquivos do tipo PDF
                'max:2048', // Tamanho máximo do arquivo em kilobytes (2048 KB = 2 MB)
            ],
            'emission_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'O usuário informado não existe.',
            'file.required' => 'The file is required.',
            'file.file' => 'The file must be a valid file.',
            'file.mimes' => 'The file must be a PDF file.',
            'file.max' => 'The file may not be greater than 2 MB.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Verifica se o usuário tem mais de 5 documentos
            $user_id = $this->input('user_id');
            $student = Student::where('user_id', $user_id)->first();
            $documentCount = StudentDocument::where('student_id', $student->id)->count();

            if ($documentCount >= 3) {
                $validator->errors()->add('user_id', 'O usuário já atingiu o limite de 3 documentos.');
            }

            // Verifica se o doc_type já foi utilizado para este usuário
            $docTypeExists = StudentDocument::where('student_id', $student->id)
                ->where('doc_type', $this->input('doc_type'))
                ->exists();

            if ($docTypeExists) {
                $validator->errors()->add('doc_type', 'Este tipo de documento já foi adicionado para este usuário.');
            }

        });
    }
}
