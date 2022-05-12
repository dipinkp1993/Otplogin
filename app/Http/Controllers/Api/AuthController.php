<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    $user=User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
   
      if($user)
      {
        Auth::login($user,true);
        $token = auth()->user()->createToken('authToken')->accessToken;
        return response(['message'=>'Success','access_token' => $token]);
       }
      else
       {
        return response()->json(['error' => 'Unauthorised'], 401);
       }
    }   
}
