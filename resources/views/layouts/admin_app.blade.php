<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Axenon</title>

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
        @yield('additionalstyles')

        <!-- Bootstrap and OneUI CSS framework -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

        <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/modern.min.css') }}">
        <!-- END Stylesheets -->
    </head>
    <body>
        <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
            <!-- Side Overlay-->
            <aside id="side-overlay">
                <!-- Side Overlay Scroll Container -->
                <div id="side-overlay-scroll">
                    <!-- Side Header -->
                    <div class="side-header side-content">
                        <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                        <button class="btn btn-default pull-right" type="button" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times"></i>
                        </button>
                        <span class="font-w600 push-10-l">Admin</span>
                    </div>
                    <!-- END Side Header -->

                    <!-- Side Content -->
                    <div class="side-content remove-padding-t">
                        <!-- Block -->
                        <div class="block pull-r-l">
                            <div class="block-header bg-gray-lighter">
                                <ul class="block-options">
                                    <li>
                                        <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                    </li>
                                    <li>
                                        <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                                    </li>
                                </ul>
                                <h3 class="block-title">Block</h3>
                            </div>
                            <div class="block-content">
                                <p>...</p>
                            </div>
                        </div>
                        <!-- END Block -->
                    </div>
                    <!-- END Side Content -->
                </div>
                <!-- END Side Overlay Scroll Container -->
            </aside>
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            <nav id="sidebar">
                <!-- Sidebar Scroll Container -->
                <div id="sidebar-scroll">
                    <!-- Sidebar Content -->
                    <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
                    <div class="sidebar-content">
                        <!-- Side Header -->
                        <div class="side-header side-content bg-white-op">
                            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                            <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times"></i>
                            </button>
                            <a class="h5 text-white sidebar-mini-hide" href="/admin/dashboard">Axenon</a>
                        </div>
                        <!-- END Side Header -->

                        <!-- Side Content -->
                        <div class="side-content">
                            <ul class="nav-main">
                                <li>
                                    <a{!! (\Request::is('admin/dashboard'))?' class="active"':'' !!} href="/admin/dashboard"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                                </li>
                                <li>
                                    <a{!! (\Request::is('admin/users'))?' class="active"':'' !!} href="/admin/users"><i class="si si-users"></i><span class="sidebar-mini-hide">Users</span></a>
                                </li>
                                <li{!! (\Request::is('admin/page*'))?' class="open"':'' !!}>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-pagelines"></i><span class="sidebar-mini-hide">Pages</span></a>
                                    <ul>
                                        <li>
                                            <a{!! (\Request::is('admin/pages'))?' class="active"':'' !!} href="/admin/pages">Pages</a>
                                        </li>
                                        <li>
                                            <a{!! (\Request::is('admin/page/create'))?' class="active"':'' !!} href="/admin/page/create">New Page</a>
                                        </li>
                                    </ul>
                                </li>
                                <li{!! (\Request::is('admin/faq*'))?' class="open"':'' !!}>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bubbles"></i><span class="sidebar-mini-hide">FAQs</span></a>
                                    <ul>
                                        <li>
                                            <a{!! (\Request::is('admin/faq-categories'))?' class="active"':'' !!} href="/admin/faq-categories">Categories</a>
                                        </li>
                                        <li>
                                            <a{!! (\Request::is('admin/faq-category/create'))?' class="active"':'' !!} href="/admin/faq-category/create">New Category</a>
                                        </li>
                                        <li>
                                            <a{!! (\Request::is('admin/faqs'))?' class="active"':'' !!} href="/admin/faqs">Faqs</a>
                                        </li>
                                        <li>
                                            <a{!! (\Request::is('admin/faq/create'))?' class="active"':'' !!} href="/admin/faq/create">New Faq</a>
                                        </li>
                                    </ul>
                                </li>
                                <li{!! (\Request::is('admin/settings*'))?' class="open"':'' !!}>
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i><span class="sidebar-mini-hide">Settings</span></a>
                                    <ul>
                                        <li>
                                            <a{!! (\Request::is('admin/settings/outbound-msg'))?' class="active"':'' !!} href="/admin/settings/outbound-msg">Outbound Msg</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a{!! (\Request::is('admin/service-package/privileges'))?' class="active"':'' !!} href="/admin/service-package/privileges"><i class="si si-wrench"></i><span class="sidebar-mini-hide">Service Privileges</span></a>
                                </li>
                            </ul>
                        </div>
                        <!-- END Side Content -->
                    </div>
                    <!-- Sidebar Content -->
                </div>
                <!-- END Sidebar Scroll Container -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="header-navbar" class="content-mini content-mini-full">
                <!-- Header Navigation Right -->
                <ul class="nav-header pull-right">
                    <li>
                        <div class="btn-group">
                            <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                                <img src="{{ asset('assets/img/avatars/avatar10.jpg') }}" alt="Avatar">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-header">Profile</li>
                                <li>
                                    <a tabindex="-1" href="javascript:void">
                                        <i class="si si-user pull-right"></i>Profile
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Actions</li>
                                <li>
                                    <a tabindex="-1" href="/admin/logout">
                                        <i class="si si-logout pull-right"></i>Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!-- END Header Navigation Right -->

                <!-- Header Navigation Left -->
                <ul class="nav-header pull-left">
                    <li class="hidden-md hidden-lg">
                        <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                        <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                            <i class="fa fa-navicon"></i>
                        </button>
                    </li>
                    <li class="hidden-xs hidden-sm">
                        <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                        <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                    </li>
                </ul>
                <!-- END Header Navigation Left -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
            		@yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
                <div class="pull-left">
                    <a class="font-w600" href="/admin/dashboard" target="_blank">Axenon</a> &copy; <span class="js-year-copy"></span>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

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

        <!-- Page Plugins -->
        <script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>

        <!-- Page JS Code -->
        <script>
            jQuery(function() {
                // Init page helpers (Slick Slider plugin)
                App.initHelpers('slick');
            });
        </script>
        <!-- Page JS Plugins + Page JS Code -->
        
        @yield('additionaljs')
    </body>
</html>