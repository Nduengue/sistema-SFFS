<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
            'user_id' => [
                'required',
                'integer',
                'min:1',
                // Adiciona a regra customizada para garantir que o `user_id` não esteja associado a outro estudante
                Rule::unique('students')->where(function ($query) {
                    return $query->where('user_id', $this->user_id);
                })
            ],
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'id_type' => 'required|integer',
            'id_number' => 'required|string|unique:students,id_number',
            'email' => 'required|email|unique:students,email',
            'phone_number' => 'required|integer',
            'address' => 'required|string',
            //'profile_picture' => 'nullable|string',
            'obs' => 'nullable|string',
            //'documents' => 'nullable|json',
        ];
    }
    
    public function messages()
    {
        return [
            'user_id.unique' => 'O Estudante já submeteu os seus Dados.',
        ];
    }
}
