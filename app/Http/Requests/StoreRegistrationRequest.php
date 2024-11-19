<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;
use App\Models\Registration;
use App\Models\ClassModel;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'obs' => 'nullable|string',
            'user_id' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Verifica se o usuário tem mais de 5 documentos
            $student_id = $this->input('student_id');
            $user_id = $this->input('user_id');
            $class_id = $this->input('class_id');

            //Verifica se Turma esta recebendo Inscrições
            $class = ClassModel::where('id', $class_id)->first();
            if (!$class || $class->status != 0) {
                // Caso a turma não exista ou não esteja aberta a novas inscrições
                $validator->errors()->add('class_id', 'Esta Turma não está aberta a Novas Inscrições.');
            }

            //Verifica se Estudante é válido
            $student = Student::where('id', $student_id)->where('user_id', $user_id)->first();
            if(!$student){
                $validator->errors()->add('student_id', 'ID de Estudante não encontrado não corresponde com user_id');
            }

            //Verifica se Estudante já tem Inscrição em Curso
            $registrations = Registration::where('student_id', $student_id)->where('class_id', $class_id)->first();
            if ($registrations && ($registrations->status == 0 || $registrations->status == 1)) {
                $validator->errors()->add('student_id', 'Estudante com Inscrição em Curso');
            }

        });
    }
}
