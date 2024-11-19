<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\SecurityController;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\User;

class LoginController extends Controller
{
    protected $securityController;

    // Construtor que injeta as dependências
    public function __construct(SecurityController $securityController)
    {
        $this->securityController = $securityController;

    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                $user = Auth::user(); // Get User Data
                if($user->account_status == 2){
                    //Account Blocked;
                    return response()->json(["message"=>"Account Blocked", "status"=>3], 200);
                }
                if($this->securityController->twoFALogin($user->email) === true ||
                        $user->account_status == 0 || $user->account_status == 10){
                    $sendCode = $this->securityController->sendEmailCode($user->email, 0, 0, 1);
                    if($sendCode !== false){
                        return response()->json(["message"=>"Code Sent to Email", "code"=>$sendCode, "status"=>4], 200);
                    }
                    return response()->json(["message"=>"Server Error"], 500);
                }
                // Gerar Token
                $token = $request->user()->createToken(
                    'token-name', ['*'],
                    now()->addMinutes(300)
                )->plainTextToken;
                if($token){
                    return response()->json([
                        "message"=>"valid data",
                        'token' => $token,
                        'info_user' => $user,
                        "status"=>1], 200
                    );
                }else{
                    return response()->json(["message"=>"Error Token", "status"=>6], 200);
                }
            }
            return response()->json(["message"=>"invalid data", "status"=>2], 200);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return $e->getResponse();
        }
    }

    public function verifyEmail(LoginRequest $request){

        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $checkEmailCode = $this->securityController->verifyIdentity($request->email, $request->code);
                    if($checkEmailCode == 1 && $user->account_status != 2){
                        $token = $request->user()->createToken(
                            'token-name', ['*'],
                            now()->addMinutes(300)
                        )->plainTextToken;

                    return response()->json([
                        'token' => $token,
                        'account_status' => $user->account_status,
                        'info_user' => $user,
                        'status' => 1
                    ], 200);

                    }else if($checkEmailCode == 2){
                    $attempts = $this->securityController->addAttempts($request->email);
                    return response()->json([
                        "message" => "Incorrect Code",
                        "attempts" => $attempts,
                        'status' => 2
                    ], 200);
                }else{return response()->json([], 500);}
            }
            return response()->json(["sms"=>"Not Authenticated", "status"=>401], 401);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return $e->getResponse();
        }

    }

    public function resendEmailCode(LoginRequest $request){

        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if (Auth::attempt($credentials)) {
                $codeSent = $this->securityController->resendEmailCode($request->email, 1);
                if($codeSent ==! false){
                    return response()->json([
                        'code' => $codeSent[0],
                        'askedTimes' => $codeSent[1],
                        'status' => 1
                    ], 200);
                }
                return response()->json([], 500);

            }
            return response()->json([
                'message' => 'User is not authorized',
                'status' => 401
            ], 401);

        }catch (\Illuminate\Validation\ValidationException $e) {
            return $e->getResponse();
        }

    }

    public function newPassword(PasswordRequest $request){

        try {
            $user = Auth::user(); // Get User Data
            if ($user->account_status !== 0) {
                return response()->json(["message"=>"No Authorized", "status"=>401]);
            }

            $user->password = Hash::make($request->newPassword);
            $user->account_status = 1;
            $saved = $user->save();
            if($saved){
                return response()->json(["message"=>"Password Changed", "status"=>1]);
            }
            return response()->json(["message" => "Failed to change password", "status" => 0]);

        }catch (\Illuminate\Validation\ValidationException $e) {
            return $e->getResponse();
        }
    }

    public function logout(Request $request){
        $logout = $request->user()->currentAccessToken()->delete();
        if($logout){
            return response()->json(["message"=>"Successfully  Logged out", "status"=>1], 200);
        }
        return response()->json(["message"=>"error server"], 500);
    }

}
