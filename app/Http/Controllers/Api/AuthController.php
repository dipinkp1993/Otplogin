<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Jobs\SendOtpJob;
use App\Http\Requests\sendEmail;
use App\Http\Requests\ConfirmOtpRequest;

class AuthController extends Controller
{
  public function sendOtp(SendEmail $request)
  {
    if(!emailExists($request->email))// check whether email exists in users model.if not redirect with an error alert.
    {
        //emailExists is a helper function that described in app\Helpers\helper.php.
        return redirect()->back()->with('error','This email is not registered with our system');
    }
    $otp=rand(10000,99999);//Generating a random 5 digit Otp number
    $details['email']=$request->email;
    $details['otp']=$otp;
    updateOtp($request->email,$otp); //updateOtp is a function to update otp of a particualr email described in app\Helpers\helper.php
    updateAttempt($request->email);//update login attempts count to null.
    dispatch(new SendOtpJob($details));
    return response(['message' => 'Success! Email Sent','status'=>true], 200); 
    
   
  }
  public function login(ConfirmOtpRequest $request)
  {
    $user=User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
   
      if($user)
      {
        Auth::login($user,true);
        updateOtp($request->email);//otp sets to '0';
        updateAttempt($request->email);//otp_attempts set to null
        $token = auth()->user()->createToken('authToken')->accessToken;
        return response(['message'=>'Success','access_token' => $token]);
       }
      else
       {
        return response()->json(['message' => 'Unauthorised'], 401);
       }
  }   
  
}
