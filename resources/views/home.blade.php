@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}<br><br>
                    Hello, {{Auth::user()->name}}<br><br>
                    Email: {{Auth::user()->email}}<br><br>
                    Avatar: <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}'s avatar" hieght="50" width="50">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
