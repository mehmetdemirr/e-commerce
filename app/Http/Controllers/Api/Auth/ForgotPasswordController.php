<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\ForgotPasswordRequest;
use App\Http\Requests\Api\PasswordForgotRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(PasswordForgotRequest $request){
        
        $input=$request->only('email');
        $user=User::where('email',$input)->first();
        $user->notify(new ResetPasswordNotification());
        $success['succees']=true;
        return response()->json([
            'success'=> true,
            'data' => null,
            'errors' => null,
            'message' => "Gönderildi",
            ], 200
        );
    }
}
