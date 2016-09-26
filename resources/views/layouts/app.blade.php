<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Admin</title>

        <meta name="description" content="Axenon">
        <meta name="author" content="Axenon">
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

        <!-- Page JS Plugins CSS go here -->

        <!-- Bootstrap and OneUI CSS framework -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

        <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/modern.min.css') }}">
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Page Container -->
        <div id="page-container" class="header-navbar-fixed header-navbar-transparent">
            <!-- Header -->
            <header id="header-navbar" class="content-mini content-mini-full">
                <div class="content-boxed">
                    <!-- Main Header Navigation -->
                    <ul class="js-nav-main-header nav-main-header pull-right">
                        <li class="text-right hidden-md hidden-lg">
                            <!-- Toggle class helper (for main header navigation in small screens), functionality initialized in App() -> uiToggleClass() -->
                            <button class="btn btn-link text-white" data-toggle="class-toggle" data-target=".js-nav-main-header" data-class="nav-main-header-o" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </li>
                        <li><a{!! (\Request::is('/'))?' class="active"':'' !!} href="/">{{ trans('pages.home') }}</a></li>
		                    <li><a href="javascript:void(0)">How It Works</a></li>
		                    <li><a href="javascript:void(0)">{{ trans('pages.contact_us') }}</a></li>
		                    <li><a href="/user/login">{{ trans('pages.login') }}</a></li>
                    		<li><a href="/user/register">{{ trans('pages.register') }}</a></li>
                    		<li><a href="/user/register-flex">Register Flex</a></li>
                    </ul>
                    <!-- END Main Header Navigation -->

                    <!-- Header Navigation Left -->
                    <ul class="nav-header pull-left">
                        <li class="header-content">
                            <a class="h5 text-white" href="/">Axenon</a>
                        </li>
                    </ul>
                    <!-- END Header Navigation Left -->
                </div>
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
            		@yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-white">
                <div class="content content-boxed">
                    <!-- Footer Navigation -->
                    <div class="row push-30-t items-push-2x">
                        <div class="col-sm-4">
                            <h3 class="h5 font-w600 text-uppercase push-20">Links</h3>
                            <ul class="list list-simple-mini font-s13">
                                <li>
                                    <a class="font-w600" href="javascript:void(0)">Link #1</a>
                                </li>
                                <li>
                                    <a class="font-w600" href="javascript:void(0)">Link #2</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="h5 font-w600 text-uppercase push-20">Links</h3>
                            <ul class="list list-simple-mini font-s13">
                                <li>
                                    <a class="font-w600" href="javascript:void(0)">Link #1</a>
                                </li>
                                <li>
                                    <a class="font-w600" href="javascript:void(0)">Link #2</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="h5 font-w600 text-uppercase push-20">Contact Us</h3>
                            <div class="font-s13 push">
                                <strong>Axenon AB</strong><br>
                                Kista Science Tower,<br>
                                164 51 Kista,<br>
                                Sweden<br>
                                <abbr title="Phone">P:</abbr> +46 8 44 686 000
                            </div>
                            <div class="font-s13">
                                <i class="si si-envelope-open"></i> sales@axenon.se
                            </div>
                        </div>
                    </div>
                    <!-- END Footer Navigation -->

                    <!-- Copyright Info -->
                    <div class="font-s12 push-20 clearfix">
                        <hr class="remove-margin-t">
                        <div class="pull-left">
                            <a class="font-w600" href="http://goo.gl/6LF10W" target="_blank">Axenon</a> &copy; <span class="js-year-copy"></span>
                        </div>
                    </div>
                    <!-- END Copyright Info -->
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
        <script src="{{ asset('assets/js/oneui.min.js') }}"></script>

        <!-- Page JS Plugins + Page JS Code -->
    </body>
</html>