<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SecurityController;
use App\Jobs\SendEmailWelcomeUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $securityController;
    protected $sendEmailController;

    // Construtor que injeta as dependências
    public function __construct(SecurityController $securityController, SendEmailController $sendEmailController)
    {
        $this->securityController = $securityController;
        $this->sendEmailController = $sendEmailController;
    }

    public function authenticated()
    {
        $user = Auth::user();
        if($user){
            return $user;
        }
        return response()->json([], 401);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Verificamos se o parâmetro 'search_data' foi informado e aplicamos o filtro
        if ($request->has('search_data')) {
            $searchData = $request->input('search_data');
            $query->where(function($query) use ($searchData) {
                $query->where('name', 'like', '%' . $searchData . '%')
                      ->orWhere('email', 'like', '%' . $searchData . '%');
            });
        }

        // Verificamos se o parâmetro 'start_date' foi informado e aplicamos o filtro
        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->input('start_date'));
        }

        // Verificamos se o parâmetro 'end_date' foi informado e aplicamos o filtro
        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->input('end_date'));
        }

        // Executamos a query e obtemos os resultados
        $users = $query->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Verifica se o e-mail já existe
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Email already exists.', 'status'=>2], 200);
        }

        // Gerar uma senha aleatória
        $password = Str::random(10); // Gera uma senha de 10 caracteres

        // Adiciona a senha criptografada ao array de dados
        $userData = $request->all();
        $userData['password'] = bcrypt($password);
       
        // Cria o novo usuário utilizando o método create
        $user = User::create($userData);
        if($user){
            //$this->sendEmailController->sendWelcomeEmail($user->email, $password, $request->name);
            SendEmailWelcomeUser::dispatch($user->name, $user->email, $password);
            return response()->json(['message' => 'User Stored successfully.', 'user' => $user, "status"=>1], 200);
        }
        return response()->json(['message' => 'Error Server'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if ($user) {
            // Retorna o usuário encontrado em formato JSON
            return response()->json($user);
        }

        // Retorna uma resposta JSON com mensagem de erro e status 404 se o usuário não for encontrado
        return response()->json(['message' => 'User not found.'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        // Encontra o usuário pelo ID
        $user = User::find($id);

        // Verifica se o usuário existe
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Atualiza os atributos permitidos
        $user->name = $request->input('name');
        $user->privileges = $request->input('privileges');
        $user->account_status = $request->input('account_status');

        // Verifica se houve alterações antes de chamar update
        if (!$user->isDirty(['name', 'privileges', 'account_status'])) {
            return response()->json(['message' => 'No changes made to the user.'], 200);
        }

        // Salva as alterações
        $user->save();

        // Retorna a resposta em formato JSON
        return response()->json(['message' => 'User updated successfully.', 'user' => $user], 200);

    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tenta encontrar o usuário pelo ID
        $user = User::find($id);

        // Verifica se o usuário foi encontrado
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.', "status"=>1], 200);
        }

        // Retorna uma resposta JSON com mensagem de erro e status 404 se o usuário não for encontrado
        return response()->json(['message' => 'User not found.'], 404);
    }
}
