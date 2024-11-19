<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SecurityController;
use App\Models\User;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RecoverPassController extends Controller
{
    protected $securityController;

    // Construtor que injeta as dependências
    public function __construct(SecurityController $securityController)
    {
        $this->securityController = $securityController;
    }

    //Method to Start Recover Password
    public function recoverPassword($email){
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['message' => 'Invalid email address'], 400);
            }
            $user = User::where('email', $email)->first();
            if($user){
                if($user->account_status == 2){
                    return response()->json(["message"=>"User Blocked", "status"=>2], 200);
                }
                $user->account_status = 10;
                if($user->save()){
                    $sendCode = $this->securityController->sendEmailCode($user->email, 0, 0, 2);
                    if($sendCode !== false){
                        return response()->json(["message"=>"Code Sent to Email", "code"=>$sendCode, "status"=>1], 200);
                    }
                    return response()->json(["message"=>"Server Error"], 500);
                }
                return response()->json(["message"=>"Error Server"], 500);
            }
            return response()->json(["message"=>"User not Found", "status"=>0], 200);

        }catch (\Illuminate\Validation\ValidationException $e) {
            return $e->getResponse();
        }
    }

    //Method to Verify Email Code
    public function verifyEmail($email, $code){
        $user = User::where('email', $email)->first();
        $checkEmailCode = $this->securityController->verifyIdentity($email, $code);

        if($checkEmailCode == 1 && $user->account_status != 2){
            $token = $user->createToken(
                'token-name', ['*'],
                now()->addMinutes(30)
            )->plainTextToken;

            return response()->json([
                'token' => $token,
                'account_status' => $user->account_status,
                'status' => 1
            ], 200);

        }else if($checkEmailCode == 2){
            $attempts = $this->securityController->addAttempts($email);
            return response()->json([
                "message" => "Incorrect Code",
                "attempts" => $attempts,
                'status' => 2
            ], 200);
        }else{return response()->json([], 500);}
    }

    //Method to Rsend Email Code
    public function resendEmailCode($email){

        try {
            $codeSent = $this->securityController->resendEmailCode($email, 2);
            if($codeSent ==! false){
                return response()->json([
                    'code' => $codeSent[0],
                    'askedTimes' => $codeSent[1],
                    'status' => 1
                ], 200);
            }
            return response()->json([], 500);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return $e->getResponse();
        }

    }

    //Method to Update Password
    public function updatePassword(PasswordRequest $request){

        $user = Auth::user(); // Get User Data
        if ($user->account_status !== 10) {
            return response()->json(["message"=>"No Authorized", "status"=>401]);
        }

        $user->password = Hash::make($request->newPassword);
        $user->account_status = 1;
        $saved = $user->save();
        if($saved){
            return response()->json(["message"=>"Password Changed", "status"=>1]);
        }
        return response()->json(["message" => "Failed to change password", "status" => 0]);
    }
}
