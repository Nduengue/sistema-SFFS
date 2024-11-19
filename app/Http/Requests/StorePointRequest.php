<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StorePointRequest extends FormRequest
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
            "student_id"=>"required|integer",
            "classroom_id"=>"required|integer",
            "user_id"=>"required|integer",
            "point"=>"required|integer",
            "date"=>"required|date"
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'point' => $this->input('point', 0), 
            'date' => $this->input('date', date("Y-m-d")),
        ]);
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erro de validação !',
            'errors' => $validator->errors()
        ], 422));
    }
}
