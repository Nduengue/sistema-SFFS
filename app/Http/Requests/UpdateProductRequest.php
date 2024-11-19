<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $id = $this->route('product'); // Obtém o ID do registro que está sendo atualizado

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                // Verifica que a combinação de title e course_id é única
                Rule::unique('products')->where(function ($query) {
                    return $query->where('course_id', $this->input('course_id'));
                })->ignore($id),
            ],
            'price' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'The combination of this title and id_course already exists. Please choose a different combination.',
        ];
    }
}
