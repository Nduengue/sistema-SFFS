<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Registration;

class StorePaymentRequest extends FormRequest
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
            'registration_id' => 'required|exists:registrations,id',
            'payment_method' => 'sometimes|required|in:1,2,3',
            'amount' => 'sometimes|required|numeric|min:0',
            'file' => [
                'required', // ou 'nullable' se a imagem for opcional
                'file', // Verifica se o arquivo é um arquivo
                'mimes:pdf', // Permite apenas arquivos do tipo PDF
                'max:2048', // Tamanho máximo do arquivo em kilobytes (2048 KB = 2 MB)
            ],
            'payment_date' => 'nullable|date',
            'status' => 'sometimes|required|in:0,1,2,3',
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Verifica se o usuário tem mais de 5 documentos
            $user_id = $this->input('user_id');
            $student = Student::where('user_id', $user_id)->first();
            $registration = Registration::where('student_id', $student->id)
                            ->orderBy('id', 'desc') // Ordena pela coluna 'id' em ordem decrescente
                            ->first();                

            if ($registration) {
                $payments = Payment::where('registration_id', $registration->id)->first();
                if($payments){
                    if($payments->status == 3){
                        $validator->errors()->add('file', 'O Estudante Já tem um Pagamento de Inscrição por Validar.');
                    }
                    if($payments->status == 1){
                        $validator->errors()->add('file', 'O Estudante Já tem o Pagamento de Inscrição Validado.');
                    }
                }
            }

        });
    }
    
}
