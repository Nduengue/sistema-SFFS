<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserSettingsRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSettingsController extends Controller
{
    public function updateUserSettings(UserSettingsRequest $request)
    {
        $user = Auth::user(); // Obtém os dados do usuário
        // Verifica se a senha atual corresponde à senha armazenada no servidor
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(["message" => "Incorrect Password"], 401);
        }
        $user->settings = $request->settings;
        $saved = $user->save();
        if ($saved) {
            return response()->json(["message" => "Settings Updated"], 200);
        }
        return response()->json([], 500);
    }
}
