<!DOCTYPE HTML>
<html>

<head>
     <title>
        @section('title')
        | {{$settings->attigo__store_name__c or 'Attigo One'}}
        @show
    </title>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="TheBox - premium e-commerce template">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('/assets/img/thebox/favicons/favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="http://pst1.herokuapp.com/assets/img/thebox/favicons/favicon.png"/>

        <!-- <link href='http://fonts.googleapis.com/css?family=Roboto:500,300,700,400italic,400' rel='stylesheet' type='text/css'> -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'> -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'> -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
     --><link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/modern.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/thebox/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/thebox/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/thebox/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/thebox/mystyles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/thebox/jquery.auto-complete.css') }}">
    @if(isset($css) && $css!='')
    <link rel="stylesheet" href="{{ $css }}">
    @endif
    @if(isset($schema))
    <link rel="stylesheet" href="{{ asset('assets/css/thebox/schemes/'.$schema.'.css') }}">
    @endif

    @yield('additionalstyles')
    
</head>


<body>


    <div class="global-wrapper clearfix" id="global-wrapper">
        <div class="navbar-before mobile-hidden navbar-before-inverse">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="navbar-before-sign">{!! $slogan !!}</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav navbar-nav navbar-right navbar-right-no-mar">

                        @forelse($main_menu as $id=>$menu)
                            <li><a href="{{url('main-page/'.str_slug($menu))}}">{{ $menu }}</a>
                            </li>
                        @empty
                         {{''}}
                         @endforelse
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-login-dialog">
            <h3 class="widget-title">Member Login</h3>
            <p>Welcome back, friend. Login to get started</p>
            <hr />
            <form>
                <div class="form-group">
                    <label>Email or Username</label>
                    <input class="form-control" type="text" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="text" />
                </div>
                <div class="checkbox">
                    <label>
                        <input class="i-check" type="checkbox" />Remeber Me</label>
                </div>
                <input class="btn btn-primary" type="submit" value="Sign In" />
            </form>
            <div class="gap gap-small"></div>
            <ul class="list-inline">
                <li><a href="#nav-account-dialog" class="popup-text">Not Member Yet</a>
                </li>
                <li><a href="#nav-pwd-dialog" class="popup-text">Forgot Password?</a>
                </li>
            </ul>
        </div>
        <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-account-dialog">
            <h3 class="widget-title">Create {{ $settings->attigo__store_name__c or 'AttigoOne' }} Account</h3>
            <p>Ready to get best offers? Let's get started!</p>
            <hr />
            <form>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="text" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="text" />
                </div>
                <div class="form-group">
                    <label>Repeat Password</label>
                    <input class="form-control" type="text" />
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input class="form-control" type="text" />
                </div>
                <div class="checkbox">
                    <label>
                        <input class="i-check" type="checkbox" />Subscribe to the Newsletter</label>
                </div>
                <input class="btn btn-primary" type="submit" value="Create Account" />
            </form>
            <div class="gap gap-small"></div>
            <ul class="list-inline">
                <li><a href="#nav-login-dialog" class="popup-text">Already Memeber</a>
                </li>
            </ul>
        </div>
        <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-pwd-dialog">
            <h3 class="widget-title">Password Recovery</h3>
            <p>Enter Your Email and We Will Send the Instructions</p>
            <hr />
            <form>
                <div class="form-group">
                    <label>Your Email</label>
                    <input class="form-control" type="text" />
                </div>
                <input class="btn btn-primary" type="submit" value="Recover Password" />
            </form>
        </div>
        <nav class="navbar navbar-default navbar-main-white navbar-pad-top navbar-first">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ $logo }}" alt="{{ $settings->attigo__store_name__c or 'AttigoOne' }}" title="{{ $settings->attigo__store_name__c or 'AttigoOne' }}" />
                    </a> 
                </div>
                <form id="search"  class="navbar-form navbar-left navbar-main-search navbar-main-search-category" role="search" style="padding: 0px;">
                    
                    <div class="form-group">
                        <input class="form-control" name="query" id="query" type="text" value="{{ $q or '' }}" placeholder="@lang('general.search_products')Search Products..." />
                    </div>
                    <a onclick="$('#search').submit();" class="fa fa-search navbar-main-search-submit" href="#"></a>
                </form>
                <ul class="nav navbar-nav navbar-right navbar-mob-item-left">
                   <!--  <li><a href="#nav-login-dialog" data-effect="mfp-move-from-top" class="popup-text"><span >Hello, Sign in</span>Your Account</a>
                    </li> -->
                    @if(Sentinel::guest())
                        <li><a href="{{ URL::to('login') }}"><span >Hello, Sign in</span>Your Account</a>
                        </li>
                        
                    @else
                        <li {{ (Request::is('my-account') ? 'class=active' : '') }}><a href="{{ URL::to('my-account') }}">Your Account</a>
                        </li>
                        <li><a href="{{ URL::to('logout') }}">Logout</a>
                        </li>
                    @endif
                    <li class="dropdown"><a href="{{ URL::to('cart') }}"><span >Your Cart</span><i class="fa fa-shopping-cart"></i> {{ count(Cart::content()) }} Items</a>
                        <ul class="dropdown-menu dropdown-menu-shipping-cart">
                            @foreach(Cart::content() as $item)
                            <li>
                                <a class="dropdown-menu-shipping-cart-img" href="#">
                                     @if($item->options->image)
                                    <img src="{{$item->options->image}}" alt="{!! $item->name !!}" title="Image Title" />
                                   
                                    @else
                                    <img width="50" src="assets/img/default.png" alt=""></a>
                                     @endif
                                </a>
                                <div class="dropdown-menu-shipping-cart-inner">
                                    <p class="dropdown-menu-shipping-cart-price">{{$item->price}} kr</p>
                                    <p class="dropdown-menu-shipping-cart-item"><a href="{{url('products/details/'.explode(':',$item->id)[0])}}">{{$item->name}}</a>
                                    </p>
                                </div>
                            </li>
                            @endforeach
                            
                            <li>
                                <p class="dropdown-menu-shipping-cart-total">Total: {!! Cart::total() !!} kr</p>
                                {!! Form::open(['url' => route('checkout'),'id'=>'frm']) !!}
                                <input type="submit" class="dropdown-menu-shipping-cart-checkout btn btn-primary" value="Checkout" />
                                {!!Form::close() !!}
                            </li>
                        </ul>
                    </li>
                    <div class="navbar-header">
                        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-nav-collapse" area_expanded="false"><span class="sr-only">Main Menu</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                        </button>
                    </div>
                </ul>
            </div>
        </nav>
        <nav class="navbar-default navbar-main-white yamm">
            <div class="container">
                <div class="collapse navbar-collapse navbar-collapse-no-pad" id="main-nav-collapse">
                    <ul class="nav navbar-nav">
                        @foreach($main_categories as $category)
                        <li><a href="{{url('main-page/'.($category->id))}}" class="navbar-item-top">{{$category->name}}</a></li>
                        @endforeach
                                
                                
                            
                      <!--   <li class="dropdown yamm-f {!! (Request::is('products') || Request::is('single_product') || Request::is('compareproducts') || Request::is('category')  ? 'active' : '') !!}"><a href="{{ URL::to('products') }}" class="navbar-item-top" > Books<i class="drop-caret" data-toggle="dropdown"></i></a> -->
                    </li>
                    <!-- <li class="dropdown yamm-f {!! (Request::is('cart')   ? 'active' : '') !!}"><a href="{{ URL::to('cart') }}" class="navbar-item-top" > Cart</a>
                    </li> -->

        

                        <!-- <li class="dropdown yamm-fw"><a class="navbar-item-top" href="#">Pages<i class="drop-caret" data-toggle="dropdown"></i></a>
                            <ul class="dropdown-menu">
                                <li class="yamm-content">
                                    <div class="row row-eq-height row-col-border">
                                        <div class="col-md-2">
                                            <h5>Homepages</h5>
                                            <ul class="dropdown-menu-items-list">
                                                <li><a href="index.html">Layout 1</a>
                                                    <p class="dropdown-menu-items-list-desc">Default Layout</p>
                                                </li>
                                                <li><a href="index-layout-2.html">Layout 2</a>
                                                    <p class="dropdown-menu-items-list-desc">Banners Area + Product Carousel</p>
                                                </li>
                                                <li><a href="index-layout-3.html">Layout 3</a>
                                                    <p class="dropdown-menu-items-list-desc">Aside Departmens</p>
                                                </li>
                                                <li><a href="index-layout-4.html">Layout 4</a>
                                                    <p class="dropdown-menu-items-list-desc">Sidebar Right</p>
                                                </li>
                                                <li><a href="index-layout-5.html">Layout 5</a>
                                                    <p class="dropdown-menu-items-list-desc">Small Aside Departmens + Sidebar</p>
                                                </li>
                                                <li><a href="index-layout-6.html">Layout 6</a>
                                                    <p class="dropdown-menu-items-list-desc">Full Banners + Product Tabs</p>
                                                </li>
                                                <li><a href="index-layout-7.html">Layout 7</a>
                                                    <p class="dropdown-menu-items-list-desc">Small Aside Departmens + Slider</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>Category Pages</h5>
                                            <ul class="dropdown-menu-items-list">
                                                <li><a href="category.html">Layout 1</a>
                                                    <p class="dropdown-menu-items-list-desc">Default Layout</p>
                                                </li>
                                                <li><a href="category-layout-2.html">Layout 2</a>
                                                    <p class="dropdown-menu-items-list-desc">Banner Title</p>
                                                </li>
                                                <li><a href="category-layout-3.html">Layout 3</a>
                                                    <p class="dropdown-menu-items-list-desc">4 Columns Thumbs</p>
                                                </li>
                                                <li><a href="category-layout-4.html">Layout 4</a>
                                                    <p class="dropdown-menu-items-list-desc">6 Columns Small Thumbs</p>
                                                </li>
                                                <li><a href="category-layout-5.html">Layout 5</a>
                                                    <p class="dropdown-menu-items-list-desc">3 Columns Horizontal Thumbs</p>
                                                </li>
                                                <li><a href="category-layout-6.html">Layout 6</a>
                                                    <p class="dropdown-menu-items-list-desc">4 Columns Horizontal Thumbs</p>
                                                </li>
                                                <li><a href="category-layout-7.html">Layout 7</a>
                                                    <p class="dropdown-menu-items-list-desc">No Filters</p>
                                                </li>
                                                <li><a href="category-layout-8.html">Layout 8</a>
                                                    <p class="dropdown-menu-items-list-desc">Sidebar Right</p>
                                                </li>
                                                <li><a href="category-layout-9.html">Layout 9</a>
                                                    <p class="dropdown-menu-items-list-desc">Sidebar Inverse</p>
                                                </li>
                                                <li><a href="category-layout-10.html">Layout 10</a>
                                                    <p class="dropdown-menu-items-list-desc">Sidebar Color</p>
                                                </li>
                                                <li><a href="category-layout-11.html">Layout 11</a>
                                                    <p class="dropdown-menu-items-list-desc">Horizontal Thumbs</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>Product Pages</h5>
                                            <ul class="dropdown-menu-items-list">
                                                <li><a href="product-page.html">Layout 1</a>
                                                    <p class="dropdown-menu-items-list-desc">Default Layout</p>
                                                </li>
                                                <li><a href="product-layout-2.html">Layout 2</a>
                                                    <p class="dropdown-menu-items-list-desc">No Sidebar</p>
                                                </li>
                                                <li><a href="product-layout-3.html">Layout 3</a>
                                                    <p class="dropdown-menu-items-list-desc">Full Area Layout + Banners</p>
                                                </li>
                                                <li><a href="product-layout-4.html">Layout 4</a>
                                                    <p class="dropdown-menu-items-list-desc">Gallery Style</p>
                                                </li>
                                                <li><a href="product-layout-5.html">Layout 5</a>
                                                    <p class="dropdown-menu-items-list-desc">Sidebar Right</p>
                                                </li>
                                                <li><a href="product-layout-6.html">Layout 6</a>
                                                    <p class="dropdown-menu-items-list-desc">Sidebar Left</p>
                                                </li>
                                                <li><a href="product-layout-7.html">Layout 7</a>
                                                    <p class="dropdown-menu-items-list-desc">Product Gallery Left</p>
                                                </li>
                                                <li><a href="product-layout-8.html">Layout 8</a>
                                                    <p class="dropdown-menu-items-list-desc">Product Gallery Right</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>Header Layouts</h5>
                                            <ul class="dropdown-menu-items-list">
                                                <li><a href="index.html">Layout 1</a>
                                                    <p class="dropdown-menu-items-list-desc">Default Layout</p>
                                                </li>
                                                <li><a href="index-nav-layout-2.html">Layout 2</a>
                                                    <p class="dropdown-menu-items-list-desc">Center Logo + Category Nav</p>
                                                </li>
                                                <li><a href="index-nav-layout-3.html">Layout 3</a>
                                                    <p class="dropdown-menu-items-list-desc">Special Area + Extended Search</p>
                                                </li>
                                                <li><a href="index-nav-layout-4.html">Layout 4</a>
                                                    <p class="dropdown-menu-items-list-desc">White Area + Extended Search</p>
                                                </li>
                                            </ul>
                                            <hr />
                                            <h5>Footer Layouts</h5>
                                            <ul class="dropdown-menu-items-list">
                                                <li><a href="index.html">Layout 1</a>
                                                    <p class="dropdown-menu-items-list-desc">Default Layout</p>
                                                </li>
                                                <li><a href="index-footer-layout-2.html">Layout 2</a>
                                                    <p class="dropdown-menu-items-list-desc">Minimal</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>Misc</h5>
                                            <ul class="dropdown-menu-items-list">
                                                <li><a href="shopping-cart.html">Shopping Cart</a>
                                                </li>
                                                <li><a href="shopping-cart-empty.html">Cart Empty</a>
                                                </li>
                                                <li><a href="checkout.html">Checkout</a>
                                                </li>
                                                <li><a href="order-summary.html">Summary</a>
                                                </li>
                                                <li><a href="about-us.html">About Us</a>
                                                </li>
                                                <li><a href="contact.html">Contact</a>
                                                </li>
                                                <li><a href="404.html">404</a>
                                                </li>
                                                <li><a href="blog.html">Blog</a>
                                                </li>
                                                <li><a href="blog-post.html">Blog Post</a>
                                                </li>
                                                <li><a href="login-register.html">Login/Register</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown"><a class="navbar-item-top" href="#">Following</a>
                        </li>
                        <li class="dropdown"><a class="navbar-item-top" href="#">Today Delas</a>
                        </li>
                        <li class="dropdown"><a class="navbar-item-top" href="#">Gift Cards</a>
                        </li>
                        <li class="dropdown"><a class="navbar-item-top" href="#">Gift Ideas</a>
                        </li>
                        <li class="dropdown"><a class="navbar-item-top" href="#">Weekly Ad</a>
                        </li> -->
                    </ul>
                    
                </div>
            </div>
        </nav>

        @yield('content')

        
        <div class="gap"></div>

         <footer class="main-footer" style="background-color: {!! $footer_color_1 !!};">
            <div class="container">
                <div class="row">
                    <div class="col-md-9" >
                        <ul class="main-footer-links-list-lg">
                             @forelse($footer_menu as $id=>$menu)
                            <li><a href="{{url('main-page/'.str_slug($menu))}}">{{ $menu }}</a>
                            </li>
                        @empty
                         {{''}}
                         @endforelse
                        </ul>
                    </div>
                    <div class="col-md-3">
                    @if(isset($footer_image_1) && count($footer_image_1)==2)
                    <a href="{!! $footer_image_1[1] !!}" style="float: right;"><img src="{!! $footer_image_1[0] !!}"></a>
                    @endif
                        <!-- <ul class="main-footer-social-list pull-right">
                            <li>
                                <a class="fa fa-facebook" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-instagram" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus" href="#"></a>
                            </li>
                        </ul> -->
                    </div>
                </div>
                <div class="gap gap-small"></div>
            </div>
        </footer>
        <div class="copyright-area" style="background-color: {!! $footer_color_2 !!};">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="copyright-text">{!! $footer_text or '' !!}</p>
                    </div>
                    <div class="col-md-6">
                    @if( isset($footer_image_2) && count($footer_image_2)==2)
                    <a href="{!! $footer_image_2[1] !!}" style="float: right;margin-top: 15px;">
                    <img src="{!! $footer_image_2[0] !!}"></a>
                    @endif
                        <!-- <ul class="payment-icons-list">
                            <li>
                                <img src="{{ asset('/assets/img/thebox/payment/visa-straight-32px.png')}}" alt="Image Alternative text" title="Pay with Visa" />
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/thebox/payment/mastercard-straight-32px.png')}}" alt="Image Alternative text" title="Pay with Mastercard" />
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/thebox/payment/paypal-straight-32px.png')}}" alt="Image Alternative text" title="Pay with Paypal" />
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/thebox/payment/visa-electron-straight-32px.png')}}" alt="Image Alternative text" title="Pay with Visa-electron" />
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/thebox/payment/maestro-straight-32px.png')}}" alt="Image Alternative text" title="Pay with Maestro" />
                            </li>
                            <li>
                                <img src="{{ asset('/assets/img/thebox/payment/discover-straight-32px.png')}}" alt="Image Alternative text" title="Pay with Discover" />
                            </li>
                        </ul> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/thebox/jquery.js')}}"></script>
    <script src="{{ asset('assets/js/thebox/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/js/thebox/icheck.js') }}"></script>
    <script src="{{ asset('assets/js/thebox/ionrangeslider.js') }}"></script>
    <script src="{{ asset('assets/js/thebox/jqzoom.js') }}"></script>
    <script src="{{ asset('assets/js/thebox/card-payment.js') }}"></script>
    <script src="{{ asset('assets/js/thebox/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/thebox/magnific.js') }}"></script>
    <script src="{{ asset('assets/js/thebox/jquery.auto-complete.min.js') }}"></script>
    <script src="{{ asset('assets/js/thebox/custom.js') }}"></script>
    <script>
    $('input[name="query"]').autoComplete({
    minChars: 1,
    source: function(term, suggest){
        term = term.toLowerCase();
        /*var choices = [['Australia', 'au'], ['Austria', 'at'], ['Brasil', 'br']];
        var suggestions = [];
        for (i=0;i<choices.length;i++)
            if (~(choices[i][0]+' '+choices[i][1]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);
        suggest(suggestions);*/
        $.getJSON('{{url("search")}}/'+term+'/1', function(data){ suggest(data); });
    },
    renderItem: function (item, search){
        search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
        return '<div class="autocomplete-suggestion" data-id="'+item[1]+'" data-lang="'+item[0]+'" data-val="'+search+'"><img width="50px" src="'+item[2]+'"> '+item[0].replace(re, "<b>$1</b>")+'</div>';
    },
    onSelect: function(e, term, item){
        //alert('Item "'+item.data('langname')+' ('+item.data('lang')+')" selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
        /*if(e.type =='keydown'){
            var url='{{url("products/details/")}}/'+item.data('id');
        }else{
            var url='{{url("products/details/")}}/'+item.data('id');
        }
        $(location).attr('href',url);*/
        console.log('Item "'+item.data('langname')+' ('+item.data('lang')+')" selected by '+(e.type == 'keydown' ? 'pressing enter or tab' : 'mouse click')+'.');
                    $('#query').val(item.data('lang'));

        var url='{{url("products/details/")}}/'+item.data('id');
        $(location).attr('href',url);

    }
});

    $( "#search" ).submit(function( event ) {
          //alert( "Handler for .submit() called." );
          event.preventDefault();
          var query=$('#query').val();
          var url='{{url("search/")}}/'+query+'/0';
            $(location).attr('href',url);
          
        });
    
    </script>
    
    @yield('footer_scripts')




</body>

</html>
