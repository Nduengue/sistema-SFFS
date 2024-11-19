<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Verify_User;
use App\Http\Controllers\SendEmailController;
use App\Jobs\SendEmailLogin;
use App\Jobs\SendEmailResetPass;

class SecurityController extends Controller
{
    protected $sendEmailController;

    // Construtor que injeta as dependências
    public function __construct(SendEmailController $sendEmailController)
    {
        $this->sendEmailController = $sendEmailController;
    }

     //Method to check Status User Account
     public function checkUserAccountStatus($email)
     {
         $user = User::where('email', $email)->first();
         if($user){
             return $user->account_status;
         }
         return false;
     }

     //Method to check TwoFALogin actived for User
    public function twoFALogin($email)
    {
        $user = User::where('email', $email)->first();
         if($user){
             return $user->settings['twofa'];
         }
        return false;
    }

     //Method to send code to Email User
     public function sendEmailCode($email, $attemptsQtd, $resends_asked, $emailType)
     {
         Verify_User::where('email', $email)->delete();
         do{
             $code = rand(100000,999999);
             $checkCode = Verify_User::where('code', $code)->first();
         }while($checkCode);

         $add = new Verify_User;
         $add->email = $email;
         $add->code = Crypt::encryptString($code);
         $add->attempts = $attemptsQtd;
         $add->resends_asked = $resends_asked;
         $add->status = 0;
         $saved = $add->save();
         if($saved){
             // Dispatch the job to send email
             //SendEmailToLogin::dispatch($email, $code);
             //$this->sendEmail($email, $code);
             if($emailType == 1){SendEmailLogin::dispatch($email, $code);}
             if($emailType == 2){SendEmailResetPass::dispatch($email, $code);}
            
             return $code;
         }
         return false;
    }

    //Method to Verify Code sent by Email
    public function verifyIdentity($email, $code)
    {
        $verifyUser = Verify_User::where('email', $email)->first();
        if($verifyUser){
            try {
                if(Crypt::decryptString($verifyUser->code) == $code){
                   $this->deleteAttempts($email);
                   return 1;
                }else{
                   return 2;
                }
            }catch (DecryptException $e){
                return response()->json(['message' => $e->getMessage(), 'status' => 6], 200);
            }
        }else{
            return false;
        }
    }

    //Method to Resend Email Code
    public function resendEmailCode($email, $emailType)
    {
        $user = Verify_User::where('email', $email)->first();
        if($user){
            if($user->resends_asked > 1){
                $this->deleteAttempts($email);
                return false;
            }
            $resends_asked = $user->resends_asked + 1;
            return [$this->sendEmailCode($email, $user->attempts, $resends_asked, $emailType), $resends_asked];
        }else{
            return false;
        }
    }

    //Method to Add Attempts
    public function addAttempts($email)
    {
        $attempts_update = Verify_User::where('email', $email)->first();
        if($attempts_update){
            $attempts_update->increment('attempts');
            $saved = $attempts_update->save();
            if($saved){
                if($attempts_update->attempts > 2){
                    $this->deleteAttempts($email);
                }
                return $attempts_update->attempts;
            }
            return false;
        }
    }

    //Method to Delete Attempts
    public function deleteAttempts($email)
    {
        $user = Verify_User::where('email', $email)->first();
        if($user){
            return $user->delete();
        }
        return false;
    }


}
