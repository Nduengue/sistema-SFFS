<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UpdateStudentRequest extends FormRequest
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
        $studentId = $this->route('student'); // Obtém o ID do aluno da rota

        return [
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'id_type' => 'required|integer',
            'id_number' => [
                'sometimes',
                'required',
                'string',
                // Ignora o ID_Number atual na verificação de unicidade
                Rule::unique('students', 'id_number')->ignore($studentId),
            ],
            //'email' => 'required|email|unique:students,email,' . $studentId,
            'phone_number' => 'required|integer',
            'address' => 'required|string',
            'profile_picture' => 'nullable|string',
            'obs' => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $studentId = $this->route('student');
            $user_id = $this->route('user_id');
            
            // Verifica se o ID do aluno é válido
            if ($studentId) {
                $student = DB::table('students')->where('id', $studentId)->first();
                
                // Verifica se o aluno foi encontrado e se a propriedade `account_status` está disponível
                if ($student && property_exists($student, 'student_status') && $student->student_status == "1") {
                    $validator->errors()->add('student_status', 'Você não pode alterar este registro porque dados já foram validados.');
                }
            }

            if ($user_id) {
                $student = DB::table('students')->where('user_id', $user_id)->first();
    
                // Verifica se o aluno foi encontrado e se o status já foi validado
                if ($student->student_status == "1") {
                    $validator->errors()->add('student_status', 'Você não pode alterar este registro porque os dados já foram validados.');
                }
            }

        });
    }
}
