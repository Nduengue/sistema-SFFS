<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Registration;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $student = Student::where('user_id', $request->user_id)->first();
        if(!$student){
            return response()->json(["message"=>'Student not Found'], 404);
        }
        
        $file = $request->file('file');

        // Gera o nome da imagem com base no ID do usuário, data e hora atuais
        $timestamp = Carbon::now()->format('dmYHis'); // Formato: dia_mês_ano_hora_minuto_segundo
        $extension = $file->getClientOriginalExtension(); // Obtém a extensão do arquivo
        $imageName = $student->id.$timestamp . '.' . $extension; // Nome final da imagem (ID + timestamp)

        // Remove todas as imagens anteriores no diretório 'public/{id}/'
        $userDirectory = 'public/students/payment-proof/'.$student->id;
        if (Storage::exists($userDirectory)) {
            Storage::deleteDirectory($userDirectory); // Apaga o diretório inteiro, incluindo todas as imagens
        }

        // Armazena a nova imagem no diretório 'public/{id}/'
        $imagePath = $file->storeAs($userDirectory, $imageName);

        // Atualiza o campo 'arquivo' no banco de dados com o novo caminho do arquivo
        $doc = new Payment();
        $doc->registration_id = $request->registration_id;
        $doc->payment_proof = $imageName; // Supondo que você tenha uma coluna 'profile_image' na tabela 'users'
        $saved = $doc->save();

        // Retorna a resposta com base no resultado do salvamento
        if ($saved) {
            return response()->json(["message" => "Payment Proof Updated"], 200);
        }
        return response()->json([], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, string $id)
    {
        $payment = Payment::find($id);
        if($payment){
            $payment->payment_method = $request->payment_method;
            $payment->amount = $request->amount;
            $payment->payment_date = $request->payment_date;
            $payment->status = $request->status;
            $saved = $payment->save();
            if($saved){
                $registration = Registration::find($payment->registration_id);
                if($registration){
                    $registration->obs = $request->obs;
                    $registration->status = $request->status;
                    $saved_2 = $registration->save();
                    if($saved_2){
                        return response()->json(["message" => "Registration Validated"], 200);
                    }
                }
            }
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
