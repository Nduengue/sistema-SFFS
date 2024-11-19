<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use App\Models\Registration;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* $query = Registration::query();

        // Verificamos se o parâmetro 'search_data' foi informado e aplicamos o filtro
        if ($request->has('search_data')) {
            $searchData = $request->input('search_data');
            $query->where(function($query) use ($searchData) {
                $query->where('name', 'like', '%' . $searchData . '%')
                      ->orWhere('email', 'like', '%' . $searchData . '%');
            });
        } */
        $registrations = Registration::with('classModel.course', 'student', 'payment')->get();
        if ($registrations->isNotEmpty()) {
            // Aplica o filtro a cada registro
            $filteredData = $registrations->map(function ($registration) use ($request) {
                return [
                    'id' => $registration->id,
                    'start_date' => $registration->classModel->start_date,
                    'end_date' => $registration->classModel->end_date,
                    'vacancies' => $registration->classModel->vacancies,
                    'course' => [
                        'course_name' => $registration->classModel->course->course_name,
                        'price' => $registration->classModel->course->price,
                        'price_registration' => $registration->classModel->course->price_registration,
                        'duration' => $registration->classModel->course->duration,
                    ],
                    'student' => [
                        'student_name' => $registration->student->full_name,
                        'document_number' => $registration->student->id_number,
                    ],
                    'payment_data' => [
                        'payment_proof' => $registration->payment->payment_proof,
                        'amount' => $registration->payment->amount,
                        'payment_date' => $registration->payment->payment_date,
                        'payment_method' => $registration->payment->payment_method,
                        'payment_status' => $registration->payment->status,
                        'registrer_date' => $registration->payment->created_at,
                    ],
                    'obs' => $registration->obs,
                    'status' => $registration->status,
                ];
            });

            // Retorna a lista filtrada de inscrições
            return response()->json(['registrations' => $filteredData], 200);
        }

        return response()->json(['message' => 'No registrations found'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request  $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $registration = Registration::with('classModel.course', 'student', 'payment')->find($id);

        if ($registration) {
            $filteredData = [
                'id' => $registration->id,
                'start_date' => $registration->classModel->start_date,
                'end_date' => $registration->classModel->end_date,
                'vacancies' => $registration->classModel->vacancies,
                'course' => [
                    'course_name' => $registration->classModel->course->course_name,
                    'price' => $registration->classModel->course->price,
                    'price_registration' => $registration->classModel->course->price_registration,
                    'duration' => $registration->classModel->course->duration,
                ],
                'student' => [
                    'student_name' => $registration->student->full_name,
                    'document_number' => $registration->student->id_number,
                ],
                'payment_data' => [
                    'payment_proof' => $registration->payment->payment_proof,
                    'amount' => $registration->payment->amount,
                    'payment_date' => $registration->payment->payment_date,
                    'payment_method' => $registration->payment->payment_method,
                    'payment_status' => $registration->payment->status,
                    'registrer_date' => $registration->payment->created_at,
                ],
                'obs' => $registration->obs,
                'status' => $registration->status,
            ];

            return response()->json(['registration' => $filteredData], 200);
        }
    
        return response()->json(['message' => 'Registration not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegistrationRequest $request, string $id)
    {
        $registration->update($request->validated());
        return response()->json($registration);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }



    //Controladores para acesso as rotas do Portal do Estudante

    public function getAllData(Request $request)
    {
        $registrations = Registration::with('classModel.course', 'student', 'payment')->get();
        //$user_id = $request->user_id;
        // Verifica se existem registros
        if ($registrations->isNotEmpty()) {
            // Aplica o filtro a cada registro
            $filteredData = $registrations->map(function ($registration) use ($request) {
                if($request->user_id == $registration->student->user_id){
                    return [
                        'id' => $registration->id,
                        'start_date' => $registration->classModel->start_date,
                        'end_date' => $registration->classModel->end_date,
                        'vacancies' => $registration->classModel->vacancies,
                        'course' => [
                            'course_name' => $registration->classModel->course->course_name,
                            'price' => $registration->classModel->course->price,
                            'price_registration' => $registration->classModel->course->price_registration,
                            'duration' => $registration->classModel->course->duration,
                        ],
                        'student' => [
                            'student_name' => $registration->student->full_name,
                            'document_number' => $registration->student->id_number,
                        ],
                        'payment_data' => [
                            'payment_proof' => $registration->payment->payment_proof,
                            'amount' => $registration->payment->amount,
                            'payment_status' => $registration->payment->status,
                            'registrer_date' => $registration->payment->created_at,
                        ],
                        'obs' => $registration->obs,
                        'status' => $registration->status,
                    ];
                }
            });

            // Retorna a lista filtrada de inscrições
            return response()->json(['registrations' => $filteredData], 200);
        }

        return response()->json(['message' => 'No registrations found'], 404);
    }

    
    public function getOne(Request $request, string $id)
    {
        $registration = Registration::with('classModel.course', 'student', 'payment')->find($id);

        if ($registration) {
            //Cheque de User_id concide com user_id na Tabela Estudante
            if($request->user_id != $registration->student->user_id){
                return response()->json(['message' => 'Data not found'], 404);
            }
            $filteredData = [
                'id' => $registration->id,
                'start_date' => $registration->classModel->start_date,
                'end_date' => $registration->classModel->end_date,
                'vacancies' => $registration->classModel->vacancies,
                'course' => [
                    'course_name' => $registration->classModel->course->course_name,
                    'price' => $registration->classModel->course->price,
                    'price_registration' => $registration->classModel->course->price_registration,
                    'duration' => $registration->classModel->course->duration,
                ],
                'student' => [
                    'student_name' => $registration->student->full_name,
                    'document_number' => $registration->student->id_number,
                ],
                'payment_data' => [
                    'payment_proof' => $registration->payment->payment_proof,
                    'amount' => $registration->payment->amount,
                    'payment_status' => $registration->payment->status,
                    'registrer_date' => $registration->payment->created_at,
                ],
                'obs' => $registration->obs,
                'status' => $registration->status,
            ];

            return response()->json(['registration' => $filteredData], 200);
        }
    
        return response()->json(['message' => 'Registration not found'], 404);
    }


}
