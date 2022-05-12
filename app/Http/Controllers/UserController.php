<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\sendEmail;
use App\Http\Requests\ConfirmOtpRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Jobs\SendOtpJob;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function emailOtpView()
    {
        return view('auth.sendOtp');// first page view for send otp to an inputted email
    }
    public function emailOtpSend(SendEmail $request)//A function to send email to entered email through database queue
    {
        if(!emailExists($request->email))// check whether email exists in users model.if not redirect with an error alert.
        {
            //emailExists is a helper function that described in app\Helpers\helper.php.
            return redirect()->back()->with('error','This email is not registered with our system');
        }
        $otp=rand(10000,99999);//Generating a random 5 digit Otp number
        session()->put('email',$request->email);
        $details['email']=$request->email;
        $details['otp']=$otp;
        updateOtp($request->email,$otp); //updateOtp is a function to update otp of a particualr email described in app\Helpers\helper.php
        updateAttempt($request->email);//update login attempts count to null.
        dispatch(new SendOtpJob($details)); //php artisan make:job SendOtpJob.Jobs created for sending otp to entered email.
        return to_route('otp.confirmation.view')->with('success','An otp has been sent to '.$request->email);//redirect ro confirm otp page with success full alert notification.to_route new redirect function in laravel 9
        //to_route('routename')
    }
    public function otpConfirmationView()
    {
        if(!session()->has('email'))
        {
            return to_route('email.otp.view');//users cannot access this page if email session is not set in emailOtpSend function.
        }
        return view('auth.otpLogin');
    }
    public function otpConfirmationLogin(ConfirmOtpRequest $request)
    {
        //dd($request->email);
      $user=User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();//check user model with email and otp
      if($user)
      {
        Auth::login($user,true);//if user exists,login success
        updateOtp($request->email);//otp sets to '000000;
        updateAttempt($request->email);
        session()->forget('email');//seesion deleted
        return to_route('home')->with('success','Sucessfully logged in');//redirect to successful page,home page.
      }
      else
      {
        return redirect()->back()->with('error','Invalid Otp');//if not user model not found redirect back with error notifcation
      }
  }
}
