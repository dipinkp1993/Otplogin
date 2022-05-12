<?php

use App\Models\User;

function emailExists($email)
{
    if(User::where('email',$email)->exists())
    {
        return true;//if email exists return true
    }
    else
    {
        return false;//if email does not exists return false
    }
}
function updateOtp($email,$otp=0)
{
    $user = User::where('email','=',$email)->update(['otp' => $otp]);//update otp for user with email.when user successfully logged or new otpemail is sent otp sets to 0.
}
 function incrementLoginAttempt($email)
{
   $user=User::where('email',$email)->first();//check user model with email given
   $attempt_count=1;//attempt_count initializes to 1;
   if(is_null($user->login_attempts))//at start login_attempts will be null .that is checking here
   {
    $user->update(['login_attempts' =>$attempt_count]);//user model is updated with $attempt_count variable that was initializes to 1 for first attempt
   }
   else// if login_attempts is not null 
   {
       $attempt_count=$user->login_attempts;//assigend current login_attempts value from user model to $attempt count varable
       $attempt_count++;//incre,ent login attempt count
       $user->update(['login_attempts' =>$attempt_count]);//update with incremented login attempt count

   }
}
   function checkExceededAttempts($email)
   {
    $user=User::where('email',$email)->first();
    return $user->login_attempts;//check users current login attempt count

   }
   function updateAttempt($email)
   {
    $user = User::where('email','=',$email)->update(['login_attempts' => null]);//updating login_attempts count to null when sending email for new work flow
   }
   function whetherCorrectOtp($email,$otp)
   {
    $user=User::where('email',$email)->first();
    if($otp==$user->otp)
    {
        return true;//if otp is valid for third attempt,it returns true
    }
    return false;//if otp is not valid,it returns to false

   }
?>