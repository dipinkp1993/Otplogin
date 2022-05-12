@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-default">{{ __('Confirm Otp') }}</div>

                <div class="card-body">
                    @if(Session::has('success'))
                         <p class="alert alert-success alert-dismissibl"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('success') }}</p>
                    @endif
                    @if(Session::has('error'))
                         <p class="alert alert-danger alert-dismissible"> <button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('error') }}</p>
                    @endif
                    <form method="POST" action="{{ route('otp.confirmation.login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{session()->get('email')}}" readonly>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('OTP') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('otp') is-invalid @enderror" name="otp">

                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm OTP') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
