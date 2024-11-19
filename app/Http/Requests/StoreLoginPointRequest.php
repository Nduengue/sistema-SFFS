<?php

namespace App\Http\Requests;

use App\Models\AuditSetting;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreLoginPointRequest extends FormRequest
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
            "date"=>"required|date",
            "point"=>"nullable",
            "token"=>"required",
            "ip"=>"required|ip"
        ];
    }
    protected function prepareForValidation()
    {
        if(!empty(AuditSetting::find(1))){
            $point = (AuditSetting::find(1)->ip == $this->input('ip')) ? 0 : 1 ; //
            $this->merge([
                'student_id' => $this->input('student_id', 0), 
                'user_id' => $this->input('user_id', 0), 
                'point' => $this->input('point', $point), 
                'date' => $this->input('date', date("Y-m-d")),
            ]);
        }else
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erro de validação !',
            'errors' => "Configurar o IP da Rede"
        ], 422));
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
