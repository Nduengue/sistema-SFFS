<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfilePasswordRequest;
use App\Http\Requests\UpdateProfilePhotoRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if($user){
            return $user;
        }
        return response()->json([], 401);
    }
    
    /**
     * Update Password User.
     */
    public function updateUserPassword(UpdateProfilePasswordRequest $request)
    {
        $user = Auth::user(); // Obtém os dados do usuário
        // Verifica se a senha atual corresponde à senha armazenada no servidor
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(["message" => "A senha atual está incorreta", "status" => 4]);
        }

        // Verifica se a nova senha é diferente da senha atual
        if (Hash::check($request->newPassword, $user->password)) {
            return response()->json(["message" => "Nenhuma alteração detectada na senha", "status" => 5]);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        $saved = $user->save();
        if ($saved) {
            return response()->json(["message" => "Password Updated"], 200);
        }
        return response()->json([], 500);
    }

    /**
     * Update Photo User.
     */
    public function updateUserPhoto(UpdateProfilePhotoRequest $request)
    {
        $user = Auth::user(); // Obtém os dados do usuário
        $profileImage = $request->file('profileImage');

        // Gera o nome da imagem com base no ID do usuário, data e hora atuais
        $timestamp = Carbon::now()->format('dmYHis'); // Formato: dia_mês_ano_hora_minuto_segundo
        $extension = $profileImage->getClientOriginalExtension(); // Obtém a extensão do arquivo
        $imageName = $user->id.$timestamp . '.' . $extension; // Nome final da imagem (ID + timestamp)

        // Remove todas as imagens anteriores no diretório 'public/{id}/'
        $userDirectory = 'public/corporate/'.$user->id;
        if (Storage::exists($userDirectory)) {
            Storage::deleteDirectory($userDirectory); // Apaga o diretório inteiro, incluindo todas as imagens
        }

        // Armazena a nova imagem no diretório 'public/{id}/'
        $imagePath = $profileImage->storeAs($userDirectory, $imageName);

        // Atualiza o campo 'profile_image' no banco de dados com o novo caminho da imagem
        $user->profile_image = $imageName; // Supondo que você tenha uma coluna 'profile_image' na tabela 'users'
        $saved = $user->save();

        // Retorna a resposta com base no resultado do salvamento
        if ($saved) {
            return response()->json(["message" => "Profile Picture Updated"], 200);
        }
        return response()->json([], 500);
    }

}





