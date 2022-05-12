@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard-Sucess') }}</div>

                <div class="card-body">
                    @if(Session::has('success'))
                         <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ Session::get('success') }}</div>
                    @endif

                   <img src="{{asset('/images/success.gif')}}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
