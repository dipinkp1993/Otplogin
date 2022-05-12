@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-dark bg-light mb-3">
                <div class="card-header bg-default">{{ __('Send OTP') }}</div>

                <div class="card-body">
                    @if(Session::has('success'))
                         <p class="alert alert-success">{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('error'))
                         <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                    <form method="POST" action="{{ route('email.otp.send') }}" 
                    id="emailOtpForm">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
                                 <p id = "errorFront" style = "font-size: 14px; font-weight: bold; color: red;margin-top:5px;"> 
    </p> 
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="runValidity()">
                                    {{ __('Send OTP') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
		function runValidity() {
            var errorNote = document.getElementById('errorFront');
		    var email =  document.getElementById('email').value;
			// Regular Expression (Not accepts second @ symbol
			// before the @gmail.com and accepts everything else)
			var regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			// Converting the email to lowercase
           if(regExp.test(String(email).toLowerCase()))
            {
                if(email!='')
                {
                    document.getElementById('emailOtpForm').submit();// If email is validated with regular expression true, form will be submitted

                }     
            }
            else if(email=='')
            {
                errorNote.innerHTML = 'Email address should not be empty';// Validation does not pass,error message is rendered at errorFront p tag
            }
            else
            {
                errorNote.innerHTML = 'Please Enter Vaild Email Address';// Validation does not pass,error message is rendered at errorFront p tag

            }
           
		}
	
	</script>
@endsection

