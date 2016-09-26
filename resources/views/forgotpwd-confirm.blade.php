@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Reset Password
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
                                <h3 class="widget-title">Reset your Password</h3>
            
            <p>Enter your new password details</p>
            @include('notifications')
            <form action="{{ route('forgot-password-confirm',compact(['userId','passwordResetCode'])) }}" class="omb_loginForm"  autocomplete="off" method="POST">
                {!! Form::token() !!}
                <input type="password" class="form-control" name="password" placeholder="New Password">
                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                <input type="password" class="form-control" name="password_confirm" placeholder="Confirm New Password">
                <span class="help-block">{{ $errors->first('password_confirm', ':message') }}</span>

                <input type="submit" class="btn btn-block btn-primary" value="Submit to Reset Password" style="margin-top:10px;">
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
@stop
