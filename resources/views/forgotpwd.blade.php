@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Forgot Password
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/shopping.css') }}">
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
@stop
{{-- Page content --}}
@section('content')
<div class="container">
<div class="row">
                <div class="col-md-6">
                    <header class="page-header">
                        <h1 class="page-title">My Account</h1>
                    </header>
                    <div class="box-lg">
                        <div class="row" data-gutter="60">
                            <div class="col-md-12">
                                <h3 class="widget-title">Forget Password</h3>
                            <p>Enter your email to send the password</p>
                            @include('notifications')
                            <form action="{{ route('forgot-password') }}" class="omb_loginForm" autocomplete="off" method="POST">
                                {!! Form::token() !!}
                                <div class="form-group">
                                    <label class="sr-only"></label>
                                    <input type="email" class="form-control email" name="email" placeholder="Email"
                                           value="{!! old('email') !!}">
                                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                </div>
                                <div class="form-group">
                                    <input class="form-control btn btn-primary btn-block" type="submit" value="Reset Your Password">
                                </div>
                            </form>
                        </div>
                    </div>
    </div>
</div>
</div>
</div>
@stop
@section('footer_scripts')
<!-- Page JS Plugins -->
        <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

@stop
