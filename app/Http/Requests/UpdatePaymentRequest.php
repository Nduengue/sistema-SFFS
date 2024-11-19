<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Payment;

class UpdatePaymentRequest extends FormRequest
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
            'payment_method' => 'required|in:1,2,3', // Método de Pagamento: 1=Transfêrencia Bancaria; 2=TPA; 3=Pagamento por Referência;
            'amount' => 'required|numeric|min:0',
            'payment_date' => [
                'required',
                'date',
                'before_or_equal:today', // Garante que a data não seja no futuro
                function ($attribute, $value, $fail) {
                    $minDate = now()->subDays(15)->startOfDay(); // Define a data mínima como 15 dias atrás
                    if (strtotime($value) < strtotime($minDate)) {
                        $fail('A data de pagamento não pode ser inferior a 15 dias atrás.');
                    }
                }
            ],
            'obs' => 'nullable|string',
            'status' => 'required|in:0,1,2',  // 0=Por Submeter; 1=Validado; 2=Não Validado/Cancelado;
        ];
    }

    public function withValidator($validator)
    {
        // Obter o ID da rota
        $paymentId = $this->route('id');

        // Consultar o pagamento pelo ID
        $payment = Payment::find($paymentId);

        // Adicionar uma verificação extra para o caso do pagamento não existir
        $validator->after(function ($validator) use ($payment) {
            if (!$payment) {
                $validator->errors()->add('payment_id', 'ID de Pagamento não encontrado.');
            }
            if ($payment->status == 1) {
                $validator->errors()->add('payment_id', 'Este Pagamento já se encontra validado.');
            }
        });
    }
}
