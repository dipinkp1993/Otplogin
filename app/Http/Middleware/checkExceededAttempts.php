<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkExceededAttempts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        incrementLoginAttempt($request->email);//increment the login_attempts column in user model,function described in app\Helpers\helper.php 
        if(checkExceededAttempts($request->email)>2)//check the login_attempts count in user model.function described in app\Helpers\helper.php 
        {
            if(whetherCorrectOtp($request->email,$request->otp))//if 3rd attempt is correct then need to logged in.function described in app\Helpers\helper.php
            {
                return $next($request);
            }
         return to_route('email.otp.view')->with('error','Confirmation failed.You exceeded maximum login attempts.Try again!!');//if login_attempts=3  and entered otp is wrong or validation errors redirects to send-otp interface
        }
         return $next($request);//if everything goes right,then logged in
    }
}
