@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Login
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
                                <h3 class="widget-title">Sign in</h3>
                                @include('common.notifications')

                                 <form class="js-validation-login" action="{{ url('login') }}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input class="form-control" type="text" id="login-username" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password" id="login-password" name="password">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                           <input type="checkbox" class="i-check" id="login-remember-me" name="remember"> Remember me</label>
                                    </div>
                                    <input class="btn btn-primary" type="submit" value="Sign in" />
                                </form>
                                <br /><a href="{{ route('forgot-password') }}">Forgot your Password?</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
@section('footer_scripts')
<script src="{{ asset('assets/js/core/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.scrollLock.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.appear.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.countTo.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.placeholder.min.js') }}"></script>
<script src="{{ asset('assets/js/core/js.cookie.min.js') }}"></script>
<!-- Page JS Plugins -->
        <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

        <!-- Page JS Code -->
        <script src="{{ asset('assets/js/pages/base_pages_login.js') }}"></script>
@stop

@section('content_old')
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Attigo One</title>

        <meta name="description" content="Attigo One">
        <meta name="author" content="Attigo One">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset('assets/img/favicons/favicon.png') }}">

        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}" sizes="16x16">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicons/favicon-96x96.png') }}" sizes="96x96">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicons/favicon-160x160.png') }}" sizes="160x160">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicons/favicon-192x192.png') }}" sizes="192x192">

        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/img/favicons/apple-touch-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/img/favicons/apple-touch-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/img/favicons/apple-touch-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/favicons/apple-touch-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/img/favicons/apple-touch-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/favicons/apple-touch-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/img/favicons/apple-touch-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/favicons/apple-touch-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon-180x180.png') }}">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Web fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

        <!-- Bootstrap and OneUI CSS framework -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

        <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/modern.min.css') }}">
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Login Content -->
        <div class="content overflow-hidden">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <!-- Login Block -->
                    <div class="block block-themed animated fadeIn">
                        <div class="block-header bg-primary">
                            <ul class="block-options">
                                <li>
                                    <a href="{{ route('forgot-password') }}">Forgot Password?</a>
                                </li>
                                <li>
                                    <a href="/" data-toggle="tooltip" data-placement="left" title="Home"><i class="si si-home"></i></a>
                                </li>
                                <!-- <li>
                                    <a href="/user/register" data-toggle="tooltip" data-placement="left" title="New Account"><i class="si si-plus"></i></a>
                                </li> -->
                            </ul>
                            <h3 class="block-title">Login</h3>
                        </div>
                        <div class="block-content block-content-full block-content-narrow">
                            <!-- Login Title -->
                            <h1 class="h2 font-w600 push-30-t push-5">Attigo One</h1>
                            <p>Welcome, please login.</p>
                            <!-- END Login Title -->
                            
                            @include('common.notifications')

                            <!-- Login Form -->
                            <!-- jQuery Validation (.js-validation-login class is initialized in js/pages/base_pages_login.js) -->
                            <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                            <form class="js-validation-login form-horizontal push-30-t push-50" action="{{ url('login') }}" method="post">
                            		{!! csrf_field() !!}
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary floating">
                                            <input class="form-control" type="text" id="login-username" name="email" value="{{ old('email') }}">
                                            <label for="login-username">E-Mail Address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary floating">
                                            <input class="form-control" type="password" id="login-password" name="password">
                                            <label for="login-password">Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <label class="css-input switch switch-sm switch-primary">
                                            <input type="checkbox" id="login-remember-me" name="remember"><span></span> Remember Me?
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                       <input type="submit" class="btn btn-block btn-primary" value="Login">
                                    </div>
                                </div>
                            </form>
                            <!-- END Login Form -->
                        </div>
                    </div>
                    <!-- END Login Block -->
                </div>
            </div>
        </div>
        <!-- END Login Content -->

        <!-- Login Footer -->
        <div class="push-10-t text-center animated fadeInUp">
            <small class="text-muted font-w600"><span class="js-year-copy"></span> &copy; Attigo One</small>
        </div>
        <!-- END Login Footer -->
@stop
        <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
        <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/jquery.scrollLock.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/jquery.appear.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/jquery.countTo.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/jquery.placeholder.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/js.cookie.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <!-- Page JS Plugins -->
        <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

        <!-- Page JS Code -->
        <script src="{{ asset('assets/js/pages/base_pages_login.js') }}"></script>
 