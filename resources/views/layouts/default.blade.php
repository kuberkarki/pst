<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <title>
    	@section('title')
        | Attigo One
        @show
    </title> 
    <!--global css starts-->
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

        <!-- Page JS Plugins CSS go here -->

        <!-- Bootstrap and OneUI CSS framework -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

        <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/modern.min.css') }}">
        @yield('additionalstyles')
        <!-- END Stylesheets -->
    <!--end of global css-->
    <!--page level css-->
   
    <!--end of page level css-->
</head>

<body>
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
                        <li {!! (Request::is('home') ? 'class="active"' : '') !!}><a href="{{ route('home') }}"> Home</a>
                    </li>
                   <!--  <li class="dropdown {!! (Request::is('typography') || Request::is('advancedfeatures') || Request::is('grid') ? 'active' : '') !!}"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Features</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('typography') }}">Typography</a>
                            </li>
                            <li><a href="{{ URL::to('advancedfeatures') }}">Advanced Features</a>
                            </li>
                            <li><a href="{{ URL::to('grid') }}">Grid System</a>
                            </li>
                        </ul>
                    </li> -->
                   <!--  <li class="dropdown {!! (Request::is('aboutus') || Request::is('timeline') || Request::is('faq') || Request::is('blank_page')  ? 'active' : '') !!}"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Pages</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('aboutus') }}">About Us</a>
                            </li>
                            <li><a href="{{ URL::to('timeline') }}">Timeline</a></li>
                            <li><a href="{{ URL::to('price') }}">Price</a>
                            </li>
                            <li><a href="{{ URL::to('404') }}">404 Error</a>
                            </li>
                            <li><a href="{{ URL::to('500') }}">500 Error</a>
                            </li>
                            <li><a href="{{ URL::to('faq') }}">FAQ</a>
                            </li>
                            <li><a href="{{ URL::to('blank_page') }}">Blank</a>
                            </li>
                        </ul>
                    </li> -->
                    <li class="dropdown {!! (Request::is('products') || Request::is('single_product') || Request::is('compareproducts') || Request::is('category')  ? 'active' : '') !!}"><a href="{{ URL::to('products') }}" class="dropdown-toggle" > Books</a>
                    </li>
                    <li class="dropdown {!! (Request::is('cart')   ? 'active' : '') !!}"><a href="{{ URL::to('cart') }}" class="dropdown-toggle" > Cart</a>
                    </li>
                    <li {!! (Request::is('contact') ? 'class="active"' : '') !!}><a href="#">Contact</a>
                    </li>
                    {{--based on anyone login or not display menu items--}}
                    @if(Sentinel::guest())
                        <li><a href="{{ URL::to('login') }}">Login</a>
                        </li>
                        
                    @else
                        <li {{ (Request::is('my-account') ? 'class=active' : '') }}><a href="{{ URL::to('my-account') }}">My Account</a>
                        </li>
                        <li><a href="{{ URL::to('logout') }}">Logout</a>
                        </li>
                    @endif
                    </ul>
                    <!-- END Main Header Navigation -->

                    <!-- Header Navigation Left -->
                    <ul class="nav-header pull-left">
                        <li class="header-content">
                            <a class="h5 text-white" href="{{ route('home') }}">Attigo One</a>
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
                                <strong>Attigo One</strong><br>
                                Kista Science Tower,<br>
                                164 51 Kista,<br>
                                Sweden<br>
                                <abbr title="Phone">P:</abbr> +46 8 44 686 000
                            </div>
                            <div class="font-s13">
                                <i class="si si-envelope-open"></i> sales@attigoone.com
                            </div>
                        </div>
                    </div>
                    <!-- END Footer Navigation -->

                    <!-- Copyright Info -->
                    <div class="font-s12 push-20 clearfix">
                        <hr class="remove-margin-t">
                        <div class="pull-left">
                            <a class="font-w600" href="http://goo.gl/6LF10W" target="_blank">Attigo One</a> &copy; <span class="js-year-copy"></span>
                        </div>
                    </div>
                    <!-- END Copyright Info -->
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
       

    <!--global js starts-->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
     <script src="{{ asset('assets/js/oneui.min.js') }}"></script>
    <!--livicons-->
    <script src="{{ asset('assets/js/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/js/livicons-1.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/josh_frontend.js') }}"></script>
    <!--global js end-->
    <!-- begin page level js -->
    @yield('footer_scripts')
    <!-- end page level js -->
</body>

</html>
