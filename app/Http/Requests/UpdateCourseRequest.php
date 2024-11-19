<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
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
        $courseId = $this->route('course'); // Obtém o ID do curso da rota

        return [
            'course_name' => [
                'required',
                'string',
                // Ignora o curso atual na verificação de unicidade
                Rule::unique('courses', 'course_name')->ignore($courseId),
            ],
            'description' => 'nullable|string',
            'duration' => 'required|numeric|min:0',
            'level' => 'required|string|in:Basic,Intermediate,Advanced',
            'price' => 'required|numeric|min:0',
            'price_registration' => 'sometimes|required|numeric|min:0',
            'prerequisites' => 'nullable|array',
            'observations' => 'nullable|string|max:255',
        ];
    }
}
