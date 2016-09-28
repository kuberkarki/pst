@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Product | {{$product->name}}
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
    <form method="POST" action="{{url('cart')}}">
            <header class="page-header">
                <h1 class="page-title">{{ $product->name }}</h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li><a href="#">Home</a>
                    </li>
                    <li><a href="#">Products</a>
                    </li>
                    <li><a href="#">{{ $product->name }}</a>
                    </li>
                    <!-- <li><a href="#">{{ $product->name }}</a>
                    </li>
                    <li><a href="#">Sony</a>
                    </li>
                    <li class="active">XPERIA Z Ultra 16GB</li> -->
                </ol>
            </header>
             @include('common.notifications')

            {{Session::get('successful')}}
            <div class="row">
                <div class="col-md-5">
                    <div class="product-page-product-wrap jqzoom-stage">
                        <div class="clearfix">
                            
                                
                            

                            @if(isset($product->productsdetails->thumbnail))

                                <a href='{{ Cloudder::show($product->productsdetails->thumbnail,array("type"=>"upload","width"  => null,"height" => null,"crop"   => null))}}' id="jqzoom" data-rel="gal-1">
                                <img class="product-img" src='{{ Cloudder::show($product->productsdetails->thumbnail,array("width"=>458, "height"=>null, "crop"=>"fill", "fetch_format"=>"auto", "type"=>"upload"))}}' alt="{{ $product->name }}" title="Image Title" />
                                </a>
                            @elseif(!$product->external_product_image__c)
                                <img class="product-img" src="{{asset('/assets/img/thebox/500x500.png')}}" alt="{{$product->name }}" title="Image Title" />
                            @else
                                <img class="product-img" src="{{$product->external_product_image__c}}" alt="{{ $product->name }}" title="Image Title" />
                            @endif
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-7">
                    <div class="row" data-gutter="10">
                        <div class="col-md-8">
                            <div class="box">
                               
                                <h3>{{ $product->name }}</h3>
                                <p class="product-page-desc">{{$product->description}}</p>
                               <p class="product-page-price">{{$product->standardprice}}kr</p>
                                @if(count(explode(';',$product->tier_pricing_levels__c))>0 && count($product->pricesarr) && ($product->pricesarr[0]))
                                <div class="row">
                                     <div class="col-md-11">
                                         <table class="table table-bodered"> 
                                         <tr><th>Quantity</th><th>Unit Price</th>
                                        {{-- */$i=0;/* --}}
                                        @foreach(explode(';',$product->attigo__tier_pricing_levels__c) as $price)
                                            @if($product->pricesarr[$i])
                                           <tr><td> Minimum {{ $price}}</td><td> {{$product->pricesarr[$i]}} kr</td></tr>
                                           @endif
                                           {{-- */$i++;/* --}}
                                        @endforeach
                                         </table>
                                     </div>
                                 </div>

                                @endif

                                
                                     
                                    
                                     
                                   
                                     @if($sfsettings->manage_stock__c)

                                   @if($product->available_qty__c < $sfsettings->only_x_left__c)
                                   <div class="alert alert-danger alert-dismissable" >
                                   {{str_replace('[x]',$product->available_qty__c, $sfsettings->only_x_left_message__c)}}</div>
                                   @endif
                                @endif
                            </div>
                        </div>
                            
                        
                        <div class="col-md-4">
                            <div class="box-highlight">
                                <!-- <p class="product-page-price-list">$498</p> -->
                
                                @if($product->attigo__language__c)
                                Language:
                                    <select name="language" class="product-page-option-select" style="float: none;">
                                    @foreach($product->languages as $language)
                                        <option value="{{$language}}">{{$language}}</option>
                                    @endforeach
                                    </select>
                               @endif
                               <div class="product-page-side-section">
                                
                                 Quantity
                                 
                                 
                                     <ul class="product-page-actions-list" style="padding: 0px 15px;">
                                        <li class="product-page-qty-item">
                                        <a href="javascript:void(0)" class="product-page-qty product-page-qty-minus">-</a>
                                        <input name="qty" class="product-page-qty product-page-qty-input" type="text" value="1">
                                        <a href="javascript:void(0)" class="product-page-qty product-page-qty-plus">+</a>
                                        </li>
                                    </ul>
                                

                                 <!-- <input type="text" name="qty" value="1" style="width: 33px;"><br/><br/> -->
                               </div>
                               <div class="product-page-side-section">
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-block btn-primary  add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>Add to Cart
                                            </button> 
                                </div>



                                <!-- <a class="btn btn-block btn-primary" href="#"><i class="fa fa-shopping-cart"></i>Add to Cart</a><a class="btn btn-block btn-default" href="#"><i class="fa fa-star"></i>Wishlist</a> -->
                                <div class="product-page-side-section">
                                    <!-- <h5 class="product-page-side-title">Share This Item</h5>
                                    <ul class="product-page-share-item">
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
                                <!-- <div class="product-page-side-section">
                                    <h5 class="product-page-side-title">Shipping & Returns</h5>
                                    <p class="product-page-side-text">In the store of your choice in 3-5 working days</p>
                                    <p class="product-page-side-text">STANDARD 4.95 USD FREE (ORDERS OVER 50 USD) In 2-4 working days*</p>
                                    <p class="product-page-side-text">EXPRESS 9.95 USD In 24-48 hours (working days)*</p>
                                    <p class="product-page-side-text">* Except remote areas</p>
                                    <p class="product-page-side-text">You have one month from the shipping confirmation email.</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="gap"></div>
            <div class="tabbable product-tabs">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-list nav-tab-icon"></i>Overview</a>
                    </li>
                    <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-cogs nav-tab-icon"></i>Full Specs</a>
                    </li>
                    <li><a href="#tab-3" data-toggle="tab"><i class="fa fa-star nav-tab-icon"></i>Rating and Reviews</a>
                    </li>
                    <li><a href="#tab-4" data-toggle="tab"><i class="fa fa-plug nav-tab-icon"></i>Accessories</a>
                    </li>
                    <li><a href="#tab-5" data-toggle="tab"><i class="fa fa-comment nav-tab-icon"></i>Customer Q&A</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab-1">
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/348x382.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="col-md-6">
                                <div class="product-overview-text">
                                    <h5 class="product-overview-title">The only waterproof Full HD smartphone</h5>
                                    <p class="product-overview-desc">Waterproof**, dust resistant and with tough tempered glass coated with an anti-shatter film, this Android smartphone is much tougher than it looks.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <div class="product-overview-text text-right">
                                    <h5 class="product-overview-title">Ultra entertainment. Ultra business. An ultra experience. Experience 60% more</h5>
                                    <p class="product-overview-desc">From reading e-books to browsing web pages – the Full HD display has been optimized so you can see and experience 60% more than most smartphones.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/376x476.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/620x400.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="col-md-6">
                                <div class="product-overview-text">
                                    <h5 class="product-overview-title">Get precise</h5>
                                    <p class="product-overview-desc">Xperia Z Ultra works with a pencil or stylus, and the super responsive screen lets you to write and sketch with precise accuracy.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <div class="product-overview-text text-right">
                                    <h5 class="product-overview-title">Increase productivity</h5>
                                    <p class="product-overview-desc">An easy-toggle keyboard for one-handed input, plus multi-tasking apps that improve productivity help make this big screen Android smartphone the perfect business partner.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/430x450.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/620x323.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="col-md-6">
                                <div class="product-overview-text">
                                    <h5 class="product-overview-title">Be immersed</h5>
                                    <p class="product-overview-desc">The 6.4” TRILUMINOS™ Display with X-Reality for mobile creates rich, natural colours delivered in the crispest and sharpest images imaginable – turning every flick into a blockbuster experience.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <div class="product-overview-text text-right">
                                    <h5 class="product-overview-title">Extend the universe of Xperia Z Ultra</h5>
                                    <p class="product-overview-desc">With its tasteful design and amazing sound quality, this wireless headset can be used as either a smart mini-handset to take phone calls or a Bluetooth® headset, the perfect partner to your big screen phone.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/346x445.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/620x300.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="col-md-6">
                                <div class="product-overview-text">
                                    <h5 class="product-overview-title">Go connected</h5>
                                    <p class="product-overview-desc">A clever extension of you Xperia Z Ultra, this Android-compatible SmartWatch will keep you discreetly informed of incoming calls, messages and more.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <div class="product-overview-text text-right">
                                    <h5 class="product-overview-title">Go easy</h5>
                                    <p class="product-overview-desc">This magnet docking station is designed for ease of use, letting you charge your Xperia Z Ultra without opening the USB protective cover. And while charging, you can browse menus and view content – all from a comfortable
                                        viewing angle.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img class="product-overview-img" src="img/620x283.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Specs:</th>
                                    <th>Details:</th>
                                    <th>Description:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="product-page-features-table-specs">Warranty Terms - Parts:</td>
                                    <td class="product-page-features-table-details">1 Year</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Height:</td>
                                    <td class="product-page-features-table-details">5.7 inches</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Width:</td>
                                    <td class="product-page-features-table-details">2.9 inches</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Depth:</td>
                                    <td class="product-page-features-table-details">0.3 inches</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Weight:</td>
                                    <td class="product-page-features-table-details">6 oz</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Bluetooth-Enabled:</td>
                                    <td class="product-page-features-table-details">Yes</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Network:</td>
                                    <td class="product-page-features-table-details">Unlocked</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Phone Style:</td>
                                    <td class="product-page-features-table-details">Bar phone</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Operating System:</td>
                                    <td class="product-page-features-table-details">Android 4.3 Jelly Bean</td>
                                    <td>The master software that controls hardware functions and provides a platform on top of which any software applications will run. Commonly used systems include Microsoft Windows, Mac OS and Chrome OS for computers; Android,
                                        Apple iOS, BlackBerry and Windows Phone for cell phones; and Android, Apple iOS and Windows for tablets.</td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Touch Screen:</td>
                                    <td class="product-page-features-table-details">Yes</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">MMS:</td>
                                    <td class="product-page-features-table-details">Yes</td>
                                    <td>Multimedia Messaging Service enables cell phone users to send text messages, graphics, photos and audio and video clips to other MMS users or to e-mail accounts.</td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Color Display:</td>
                                    <td class="product-page-features-table-details">Yes</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Vibration Alert:</td>
                                    <td class="product-page-features-table-details">Yes</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Build-In GPS:</td>
                                    <td class="product-page-features-table-details">Yes</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Mobile Operating System:</td>
                                    <td class="product-page-features-table-details">Android</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs">Band and Mode:</td>
                                    <td class="product-page-features-table-details">Quad-band</td>
                                    <td>Number/type of bands and modes the phone can use, which affects coverage and capabilities.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-3">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="product-tab-rating-title">Overall Customer Rating:</h3>
                                <ul class="product-page-product-rating product-rating-big">
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="count">4.9</li>
                                </ul><small>238 customer reviews</small>
                                <p><strong>98%</strong> of reviewers would recommend this product</p><a class="btn btn-primary" href="#">Write a Review</a>
                            </div>
                            <div class="col-md-5">
                                <ul class="product-rate-list">
                                    <li>
                                        <p class="product-rate-list-item">Camera</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:95%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">95%</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">Sound Quality</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:90%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">90%</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">Screen</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:100%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">100%</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">Battery Life</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:95%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">95%</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">Look & Feel</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:100%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">100%</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="product-rate-list">
                                    <li>
                                        <p class="product-rate-list-item">5 Stars</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:96%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">210</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">4 Stars</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:3%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">10</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">3 Stars</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:0%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">0</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">2 Stars</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:2%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">6</p>
                                    </li>
                                    <li>
                                        <p class="product-rate-list-item">1 Star</p>
                                        <div class="product-rate-list-bar">
                                            <div style="width:1%;"></div>
                                        </div>
                                        <p class="product-rate-list-count">3</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr />
                        <article class="product-review">
                            <div class="product-review-author">
                                <img class="product-review-author-img" src="img/70x70.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="product-review-content">
                                <h5 class="product-review-title">Terrific Buy!</h5>
                                <ul class="product-page-product-rating">
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <p class="product-review-meta">by Keith Churchill on 08/14/2015</p>
                                <p class="product-review-body">Maecenas vestibulum primis et congue enim convallis pharetra mi diam a venenatis venenatis nibh fames pretium convallis</p>
                                <p class="text-success"><strong><i class="fa fa-check"></i> I would recommend this to a friend!</strong>
                                </p>
                                <ul class="list-inline product-review-actions">
                                    <li><a href="#"><i class="fa fa-flag"></i> Flag this review</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-comment"></i> Comment review</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-review-side">
                                <p><strong>6</strong> out of <strong>6</strong> found this review helpful</p>
                                <p class="product-review-side-sign">Was this review helpful?</p><a class="product-review-rate" href="#"><i class="fa fa-thumbs-up"></i>6</a><a class="product-review-rate" href="#"><i class="fa fa-thumbs-down"></i>0</a>
                            </div>
                        </article>
                        <article class="product-review">
                            <div class="product-review-author">
                                <img class="product-review-author-img" src="img/70x70.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="product-review-content">
                                <h5 class="product-review-title">Too Big. Unusable.</h5>
                                <ul class="product-page-product-rating">
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li><i class="fa fa-star"></i>
                                    </li>
                                    <li><i class="fa fa-star"></i>
                                    </li>
                                    <li><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <p class="product-review-meta">by Carl Butler on 08/14/2015</p>
                                <p class="product-review-body">Ac donec dictum sociis pharetra cubilia bibendum convallis volutpat in placerat suscipit urna mus posuere habitasse venenatis praesent himenaeos litora arcu magna imperdiet mollis phasellus vel</p>
                                <p class="text-danger"><strong><i class="fa fa-close"></i> No, I would not recommend this to a friend.</strong>
                                </p>
                                <ul class="list-inline product-review-actions">
                                    <li><a href="#"><i class="fa fa-flag"></i> Flag this review</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-comment"></i> Comment review</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-review-side">
                                <p><strong>1</strong> out of <strong>2</strong> found this review helpful</p>
                                <p class="product-review-side-sign">Was this review helpful?</p><a class="product-review-rate" href="#"><i class="fa fa-thumbs-up"></i>1</a><a class="product-review-rate" href="#"><i class="fa fa-thumbs-down"></i>1</a>
                            </div>
                        </article>
                        <article class="product-review">
                            <div class="product-review-author">
                                <img class="product-review-author-img" src="img/70x70.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="product-review-content">
                                <h5 class="product-review-title">Worth it</h5>
                                <ul class="product-page-product-rating">
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <p class="product-review-meta">by John Doe on 08/14/2015</p>
                                <p class="product-review-body">Rhoncus elementum lobortis parturient tempus vestibulum suscipit proin mus vel et suscipit consequat ornare senectus elit lacus aenean commodo nostra senectus nascetur dignissim dictumst cubilia eget porta pharetra proin
                                    luctus</p>
                                <p class="text-success"><strong><i class="fa fa-check"></i> I would recommend this to a friend!</strong>
                                </p>
                                <ul class="list-inline product-review-actions">
                                    <li><a href="#"><i class="fa fa-flag"></i> Flag this review</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-comment"></i> Comment review</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-review-side">
                                <p><strong>6</strong> out of <strong>6</strong> found this review helpful</p>
                                <p class="product-review-side-sign">Was this review helpful?</p><a class="product-review-rate" href="#"><i class="fa fa-thumbs-up"></i>6</a><a class="product-review-rate" href="#"><i class="fa fa-thumbs-down"></i>0</a>
                            </div>
                        </article>
                        <article class="product-review">
                            <div class="product-review-author">
                                <img class="product-review-author-img" src="img/70x70.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="product-review-content">
                                <h5 class="product-review-title">Great Affordable Phone</h5>
                                <ul class="product-page-product-rating">
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <p class="product-review-meta">by Joe Smith on 08/14/2015</p>
                                <p class="product-review-body">Elit habitant dictumst sociis vitae maecenas ante est netus magna duis morbi sed porttitor dapibus risus suscipit vestibulum tellus montes leo nunc rutrum ut sed mi tincidunt</p>
                                <p class="text-success"><strong><i class="fa fa-check"></i> I would recommend this to a friend!</strong>
                                </p>
                                <ul class="list-inline product-review-actions">
                                    <li><a href="#"><i class="fa fa-flag"></i> Flag this review</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-comment"></i> Comment review</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-review-side">
                                <p><strong>5</strong> out of <strong>6</strong> found this review helpful</p>
                                <p class="product-review-side-sign">Was this review helpful?</p><a class="product-review-rate" href="#"><i class="fa fa-thumbs-up"></i>5</a><a class="product-review-rate" href="#"><i class="fa fa-thumbs-down"></i>1</a>
                            </div>
                        </article>
                        <article class="product-review">
                            <div class="product-review-author">
                                <img class="product-review-author-img" src="img/70x70.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="product-review-content">
                                <h5 class="product-review-title">Excellent</h5>
                                <ul class="product-page-product-rating">
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                    <li class="rated"><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <p class="product-review-meta">by Oliver Ross on 08/14/2015</p>
                                <p class="product-review-body">Aptent leo dapibus arcu inceptos orci nunc sollicitudin vestibulum diam magnis posuere vulputate tincidunt proin eget</p>
                                <p class="text-success"><strong><i class="fa fa-check"></i> I would recommend this to a friend!</strong>
                                </p>
                                <ul class="list-inline product-review-actions">
                                    <li><a href="#"><i class="fa fa-flag"></i> Flag this review</a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-comment"></i> Comment review</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-review-side">
                                <p><strong>8</strong> out of <strong>8</strong> found this review helpful</p>
                                <p class="product-review-side-sign">Was this review helpful?</p><a class="product-review-rate" href="#"><i class="fa fa-thumbs-up"></i>8</a><a class="product-review-rate" href="#"><i class="fa fa-thumbs-down"></i>0</a>
                            </div>
                        </article>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="category-pagination-sign">238 customer reviews found. Showing 1 - 5</p>
                            </div>
                            <div class="col-md-6">
                                <nav>
                                    <ul class="pagination category-pagination pull-right">
                                        <li class="active"><a href="#">1</a>
                                        </li>
                                        <li><a href="#">2</a>
                                        </li>
                                        <li><a href="#">3</a>
                                        </li>
                                        <li><a href="#">4</a>
                                        </li>
                                        <li><a href="#">5</a>
                                        </li>
                                        <li class="last"><a href="#"><i class="fa fa-long-arrow-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-4">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Additional Accessories</h3>
                                <ul class="product-accessory-list">
                                    <li class="product-accessory">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="#">
                                                    <img class="product-accessory-img" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="product-page-product-rating">
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                </ul>
                                                <h5 class="product-accessory-title"><a href="#">High Quality For Sony XPERIA Z AC Wall Charger USB Cable ORIGINAl OEM</a></h5>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="product-accessory-price">$10.99</p><a class="btn btn-primary" href="#"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="product-accessory">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="#">
                                                    <img class="product-accessory-img" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="product-page-product-rating">
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                </ul>
                                                <h5 class="product-accessory-title"><a href="#">1x USB Cable For XPERIA Z Ultra Charger Data 8Pin Cord</a></h5>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="product-accessory-price">$36.99</p><a class="btn btn-primary" href="#"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="product-accessory">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="#">
                                                    <img class="product-accessory-img" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="product-page-product-rating">
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                </ul>
                                                <h5 class="product-accessory-title"><a href="#">Fire Skull HAPPY Protective Shell Hard Skin Case Back Cover for Sony XPERIA Z</a></h5>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="product-accessory-price">$44.99</p><a class="btn btn-primary" href="#"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="product-accessory">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="#">
                                                    <img class="product-accessory-img" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="product-page-product-rating">
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                </ul>
                                                <h5 class="product-accessory-title"><a href="#">Leather Flip Painted For Sony XPERIA Z Ultra Stand Wallet Case Cover Card Holder</a></h5>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="product-accessory-price">$47.99</p><a class="btn btn-primary" href="#"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="product-accessory">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="#">
                                                    <img class="product-accessory-img" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="product-page-product-rating">
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                </ul>
                                                <h5 class="product-accessory-title"><a href="#">20000mAh Portable Powerbank External Battery Charger for Sony, iPhone, Samsung, HTC, LG</a></h5>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="product-accessory-price">$40.99</p><a class="btn btn-primary" href="#"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h3>What's Inculded</h3>
                                <ul class="product-accessory-included-list">
                                    <li>Sony Xperia Z Ultra Smartphone</li>
                                    <li>Sony Xperia Z Ultra C6833 4G Handset</li>
                                    <li>Battery</li>
                                    <li>Stereo Headset</li>
                                    <li>Charger</li>
                                    <li>USB Cable</li>
                                    <li>User Manuel</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-5">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <form class="product-page-qa-form">
                                    <div class="row" data-gutter="10">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Have a question? Feel free to ask." />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="btn btn-primary btn-block" type="submit" value="Ask" />
                                        </div>
                                    </div>
                                </form>
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">Is this the 6.6 inch screen?</p>
                                        <p class="product-page-qa-meta">asked by Richard Jones on 08/14/2015</p>
                                    </div>
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">No, this is the 6.4 inch screen</p>
                                        <p class="product-page-qa-meta">answered on 08/14/2015</p>
                                    </div>
                                </article>
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">for those who owns this model phone in USA, may I know if this phone has the 4G LTE in Tmobile's network? Thank you in advance.</p>
                                        <p class="product-page-qa-meta">asked by Joseph Hudson on 08/14/2015</p>
                                    </div>
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">Yes. can use TMobile LTE 1700MHZ.</p>
                                        <p class="product-page-qa-meta">answered on 08/14/2015</p>
                                    </div>
                                </article>
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">I'm from Puerto Rico! this phone work for me???</p>
                                        <p class="product-page-qa-meta">asked by Neil Davidson on 08/14/2015</p>
                                    </div>
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">Yes... It will work with any gsm radio system in the world... It does not work, however on any cdma radio system...</p>
                                        <p class="product-page-qa-meta">answered on 08/14/2015</p>
                                    </div>
                                </article>
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">so this phone works on tmobile current network ll i have to do is switch the sim card?</p>
                                        <p class="product-page-qa-meta">asked by Blake Hardacre on 08/14/2015</p>
                                    </div>
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">the phone works fine with T-mobile's 4G LTE network, all you have to do is get a micro-sim card and insert it to start using your phone, if you already have a micro-sim sized card then just plug in.</p>
                                        <p class="product-page-qa-meta">answered on 08/14/2015</p>
                                    </div>
                                </article>
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">does it work on the boost mobile network?</p>
                                        <p class="product-page-qa-meta">asked by John Mathis on 08/14/2015</p>
                                    </div>
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">It only works on gms networks so you have to check I think boost mobile is cmd network like verizon towers not sure</p>
                                        <p class="product-page-qa-meta">answered on 08/14/2015</p>
                                    </div>
                                </article>
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">Is this version waterproof?</p>
                                        <p class="product-page-qa-meta">asked by Brandon Burgess on 08/14/2015</p>
                                    </div>
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">All Sony Xperia z lines are water proof the Sony Xperia z1,z2,z3,z ultra all of those</p>
                                        <p class="product-page-qa-meta">answered on 08/14/2015</p>
                                    </div>
                                </article>
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">how strong is the phone..does the screen crack easily ?</p>
                                        <p class="product-page-qa-meta">asked by Blake Abraham on 08/14/2015</p>
                                    </div>
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">Is strong enough to keep running even if it drops a few times, but I reckon if you kick it it Will smash, as any smartphone in the World. I had it for 3 months and it hasn't got a scratch.</p>
                                        <p class="product-page-qa-meta">answered on 08/14/2015</p>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            <h3 class="widget-title">You Might Also Like</h3>
            <div class="row" data-gutter="15">
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels"></ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">Apple iPhone 4S 16GB Factory Unlocked Black and White Smartphone</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">$51</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels">
                            <li>-20%</li>
                        </ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">LG G Flex D959 - 32GB - Titan Silver GSM Unlocked Android Smartphone (B)</h5>
                            <div class="product-caption-price"><span class="product-caption-price-old">$85</span><span class="product-caption-price-new">$68</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels"></ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">HTC One M8 32GB Factory Unlocked Smartphone  Gold / Silver Gray</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">$86</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels"></ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">Samsung Galaxy Note 4 IV 4G FACTORY UNLOCKED Black or White</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">$68</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" data-gutter="15">
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels"></ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/490x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">Motorola XT1096 Moto X 2nd Generation 16GB Verizon Wireless gsm unlocked</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">$88</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>4 left</li>
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels"></ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">LG G3 VS985 - 32GB - Verizon Smartphone - Metallic Black or Silk White - Great</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">$94</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>3 left</li>
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels"></ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">Apple iPhone 5c - 16GB - GSM Factory Unlocked White Blue Green Pink Yellow</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">$62</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product ">
                        <ul class="product-labels"></ul>
                        <div class="product-img-wrap">
                            <img class="product-img-primary" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                            <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="#"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                                <li class="rated"><i class="fa fa-star"></i>
                                </li>
                            </ul>
                            <h5 class="product-caption-title">Samsung Galaxy S6 Edge+ Factory Unlocked GSM 32GB</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">$109</span>
                            </div>
                            <ul class="product-caption-feature-list">
                                <li>Free Shipping</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
            </form>
        </div>
@stop
@section('content_old')
<div class="container"> 
<div class="bg-primary-dark-op">
    <section class="content content-full content-boxed overflow-hidden">
        <!-- Section Content -->
        <div class="text-center">
           
           
        <!-- END Section Content -->
        </div>
    </section>
</div>
  <div class="bg-white">
    <div class="block">
        <div class="block-content">
        <div>
            <h3 class="text-primary">{{ $product->name }}</h3>

        </div>
                    <!--main content-->
                    
         <!-- Notifications -->
        @include('common.notifications')

       {{Session::get('successful')}}
        <div class="col">
                <div class="block"><!--features_items-->
                    
                   
                      <form method="POST" action="{{url('cart')}}">
                    <div class="col-sm-2">
                        @if($product->external_product_image__c)
                            <img src="{!! $product->external_product_image__c !!}" alt="img"
                                 class="img-responsive"/>
                        @else
                            <img src="http://placehold.it/150x200" alt="..."
                                 class="img-responsive"/>
                        @endif
                    </div>

                    <div class="col-sm-10">
                        <div class="product-image-wrapper">
                            <div >
                               <p class="text-primary">{{$product->description}}</p>
                               @if($product->language__c)
                                Language:
                                <select name="language">
                                @foreach($product->languages as $language)
                                    <option value="{{$language}}">{{$language}}</option>
                                @endforeach
                                </select>
                               @endif
        

                               
                                <h2>{{$product->standardprice}} kr</h2>
                                @if($product->tier_pricing_levels__c)
                                <div class="row">
                                 <div class="col-sm-4">
                                 <table class="table table-bodered"> 
                                 <tr><th>Quantity</th><th>Unit Price</th>
                                {{-- */$i=0;/* --}}
                                @foreach(explode(';',$product->tier_pricing_levels__c) as $price)
                                    @if($product->pricesarr[$i])
                                   <tr><td> Minimum {{ $price}}</td><td> {{$product->pricesarr[$i]}} kr</td></tr>
                                   @endif
                                   {{-- */$i++;/* --}}
                                @endforeach
                                 </table></div></div>

                                @endif


<!-- 
                             @if($product->prices->tier2_to_5__c)
                                 <div class="row">
                                 <div class="col-sm-4">
                                 <table class="table table-bodered"> 
                                 <tr><th>Quantity</th><th>Unit Price</th>

                               @if($product->prices->tier2_to_5__c)
                                   <tr><td>Minimum 2</td> <td>${{$product->prices->tier2_to_5__c}}</td></tr>
                                 @endif    
                            @if($product->prices->tier6_to_10__c)
                                   <tr><td> Minimum 6 </td> <td>${{$product->prices->tier6_to_10__c}}
                                   </td></tr>
                                 @endif    
                            @if($product->prices->tier11_to_25__c)
                                   <tr><td>Minimum 11</td><td> ${{$product->prices->tier11_to_25__c}}</td></tr>
                                 @endif    
                            @if($product->prices->tier25_49__c)
                                   <tr><td>Minimum 25</td><td> ${{$product->prices->tier25_49__c}}</td></tr>
                                 @endif    
                            @if($product->prices->tier50_199__c)
                                    <tr><td>Minimum 50</td><td> ${{$product->prices->tier50_199__c}}</td></tr>
                                 @endif 
                                 </table></div></div>

                                 @endif   -->
                                 <div class="row">
                                    <div class="col-sm-1" >

                                     Quantity: 
                                     </div>
                                     <div class="col" style="margin-bottom: 20px;"><input type="text" name="qty" value="1" style="width: 33px;"> </div>
                                   
                                     @if($sfsettings->manage_stock__c)

                                   @if($product->available_qty__c < $sfsettings->only_x_left__c)
                                   <div class="alert alert-danger alert-dismissable" >
                                   {{str_replace('[x]',$product->available_qty__c, $sfsettings->only_x_left_message__c)}}</div>
                                   @endif
                                @endif
                                </div>
                               
                                 </div>
                             <div class="row" style="    margin-bottom: 20px;">
                                 <div class="col-sm-1">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-fefault add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                Add to cart
                                            </button> 
                                            </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    </form>
                   
                    <!-- <ul class="pagination">
                        <li class="active"><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">»</a></li>
                    </ul> -->
                </div><!--features_items-->
            </div>
           <!--  <h3>BEST DEALS</h3> -->
            <!-- <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/htc.jpg') }}" class="img-responsive" alt="htc image"></a>
                    <br/>
                    <h5 class="text-primary">HTC Desire 816G Plus - (Blue)</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Android v4.4.2 (KitKat)</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 13 MP,Autofocus, LED flash</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.5 Inch Screen</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 1080HD Video</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16M colors</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Octa-core 1.7 GHz Cortex-</li>
                    </ul>
                    <h4 class="text-primary">Rs. 17,826 <del class="text-danger">Rs. 21,990</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div> -->
            <!-- <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.5s">
                <div class=" thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/sony.jpg') }}" class="img-responsive" alt="sony image"></a>
                    <br/>
                    <h5 class="text-primary">Sony Xperia C3 - (Black)</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Android v4.4.2 (KitKat)</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 8 MP autofocus LED flash</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.0 Inch Screen </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> TFT capacitive touchscreen </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16M colors</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Quad-core 1.2 GHz</li>
                    </ul>
                    <h4 class="text-primary">Rs. 18,088 <del class="text-danger">Rs. 21,990</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div> -->
            <!-- <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.9s">
                <div class=" thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/karbon.jpg') }}" class="img-responsive" alt="karbon image"></a>
                    <br/>
                    <h5 class="text-primary">Karbonn Titanium Octane Plus</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Android OS, v5.0.2 (Lollipop)</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16 MP,Autofocus, LED flash</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.0 inch Screen </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Nano Sim</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Quad 2.1GHz + Quad </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> LCD capacitive touchscreen,</li>
                    </ul>
                    <h4 class="text-primary">Rs. 7,700 <del class="text-danger">Rs. 13,990</del></h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div> -->
           <!--  <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="1.4s">
                <div class=" thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/nokia.jpg') }}" class="img-responsive" alt="nokia image"></a>
                    <br/>
                    <h5 class="text-primary">Microsoft Lumia 535 Dual SIM </h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Microsoft Windows Phone 8.1</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5 MP, Camera </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> autofocus, LED flash </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.0 inch Screen </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16M colors</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Dual Sim</li>
                    </ul>
                    <h4 class="text-primary">Rs. 8,571 <del class="text-danger">Rs. 10,299</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <nav>
                <ul class="pagination pull-right">
                    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">2 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">3 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>
                </ul>
            </nav>
        </div> -->
        <!-- //Best Deal Section End -->
        <!-- New Launches Section Start -->
       <!--  <div class="row">
            <h3>NEW LAUNCHES </h3>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/samsung balck.jpg') }}" class="img-responsive" alt="samsung black image"></a>
                    <br/>
                    <h5 class="text-primary">Samsung Galaxy S6 32 GB - (Black)</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Android OS, v5.0.2 (Lollipop)</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16 MP, 3456 x 4608 pixels</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.1 inches </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Nano Sim</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Quad 2.1GHz + Quad </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Internal 32 GB </li>
                    </ul>
                    <h4 class="text-primary">Rs. 49,900</h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.5s">
                <div class=" thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/samsung.jpg') }}" class="img-responsive" alt="samsung image"></a>
                    <br/>
                    <h5 class="text-primary">Samsung Galaxy S6 64 GB - (White)</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Android OS, v5.0.2 (Lollipop)</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16 MP, 3456 x 4608 pixels</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.1 inches </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Nano Sim</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Quad 2.1GHz + Quad </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Internal 64 GB </li>
                    </ul>
                    <h4 class="text-primary">Rs. 55,900</h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.9s">
                <div class=" thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/samsung balck.jpg') }}" class="img-responsive" alt="samsung black image"></a>
                    <br/>
                    <h5 class="text-primary">Samsung Galaxy S6 Edge 32 GB</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Android OS, v5.0.2 (Lollipop)</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16 MP, 3456 x 4608 pixels</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.1 inches </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Nano Sim</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Quad 2.1GHz + Quad </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Internal 32 GB </li>
                    </ul>
                    <h4 class="text-primary">Rs. 58,900</h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="1.4s">
                <div class=" thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/samsung.jpg') }}" class="img-responsive" alt="samsung image"></a>
                    <br/>
                    <h5 class="text-primary">Samsung Galaxy S6 Edge 64 GB </h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Android OS, v5.0.2 (Lollipop)</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 16 MP, 3456 x 4608 pixels</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> 5.1 inches </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Nano Sim</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Quad 2.1GHz + Quad </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Internal 64 GB </li>
                    </ul>
                    <h4 class="text-primary">Rs. 64,900</h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <nav>
                <ul class="pagination pull-right">
                    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">2 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">3 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a></li>
                </ul>
            </nav>
        </div> -->
        <!-- //New Launches Section End -->
        <!-- Womens Section Start -->
        <!-- <div class="row">
            <h3>WOMENS </h3>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/saree.jpg') }}" class="img-responsive" alt="saree image"></a>
                    <br/>
                    <h5 class="text-primary"> Vichitra Multi Colour Will Make Your Day Floral Printed Saree</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product Type - Women's Saree</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - Multi Colour</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Pattern - Printed</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Fabric - Georgette</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Machine/Hand Wash</li>
                    </ul>
                    <h4 class="text-primary">Rs. 1198.00<del class="text-danger">Rs. 1599.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.5s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/saree2.jpg') }}" class="img-responsive" alt="saree2 image"></a>
                    <br/>
                    <h5 class="text-primary">  Diva Fashion Brown Vibrant Saree With Mixed Print</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product Type - Women's Saree</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - Multi Colour</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Pattern - Printed</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Fabric - Jacquard</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Machine/Hand Wash</li>
                    </ul>
                    <h4 class="text-primary">Rs. 1078.00<del class="text-danger">Rs. 1349.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.9s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/saree3.jpg') }}" class="img-responsive" alt="saree3 image"></a>
                    <br/>
                    <h5 class="text-primary">  Bunkar Purple Ethnic Motif Resham Work Saree</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product Type - Women's Saree</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - Multi Colour</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Pattern - Printed</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Fabric - Georgette</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Machine/Hand Wash</li>
                    </ul>
                    <h4 class="text-primary">Rs. 1348.00<del class="text-danger">Rs. 1799.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="1.4s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/saree4.jpg') }}" class="img-responsive" alt="saree4 image"></a>
                    <br/>
                    <h5 class="text-primary">    Silk Bazaar Silk Casual Wear Saree - Rust Work Saree</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product Type - Women's Saree</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - Pink</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Pattern - Printed</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Length(in mtr) - 6.3 Meter </li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Dry Clean Only</li>
                    </ul>
                    <h4 class="text-primary">Rs. 1139.00<del class="text-danger">Rs. 1425.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <h5><a href="{{ URL::to('category') }}">More items</a></h5>
        </div> -->
        <!-- //Womens Section End -->
        <!-- Mens Section Start -->
        <!-- <div class="row">
            <h3>MENS </h3>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/men.jpg') }}" class="img-responsive" alt="men image"></a>
                    <br/>
                    <h5 class="text-primary">  Mario Solid Shirt</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product - Men's Club Wear</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - Blue</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Fabric - Cotton</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Machine Wash </li>
                    </ul>
                    <h4 class="text-primary">Rs. 1699.00<del class="text-danger">Rs. 1999.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.5s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/men2.jpg') }}" class="img-responsive" alt="men2 image"></a>
                    <br/>
                    <h5 class="text-primary">  Inmark White Linen Crafted Shirt</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product -Men's Club Wear</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Fabric - Cotton</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - White</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Machine/Hand Wash</li>
                    </ul>
                    <h4 class="text-primary">Rs. 1899.00<del class="text-danger">Rs. 1999.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="0.9s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/men3.jpg') }}" class="img-responsive" alt="men3 image"></a>
                    <br/>
                    <h5 class="text-primary"> Andrew Solid Shirt</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product -Men's Club Wear</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Fabric - Cotton</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - Mehroon</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Machine/Hand Wash</li>
                    </ul>
                    <h4 class="text-primary">Rs. 1599.00<del class="text-danger">Rs. 1999.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3s" data-wow-delay="1.4s">
                <div class="thumbnail text-center">
                    <a href="{{ URL::to('single_product') }}"><img src="{{ asset('assets/images/cart/men4.jpg') }}" class="img-responsive" alt="men4 image"></a>
                    <br/>
                    <h5 class="text-primary"> Atelier Check Shirt</h5>
                    <ul>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Product -Men's Club Wear</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Fabric - Cotton</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Color - Multi Color</li>
                        <li><i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#787878" data-hc="787878"></i> Care - Machine/Hand Wash</li>
                    </ul>
                    <h4 class="text-primary">Rs. 1499.00<del class="text-danger">Rs. 1999.00</del> </h4>
                    <a href="{{ URL::to('single_product') }}" class="btn btn-primary btn-block text-white">View</a>
                </div>
            </div>
            <h5><a href="{{ URL::to('category') }}">More items</a></h5>
        </div> -->
        <!-- //Mens Section End -->
        <!-- //Content Section End -->
    </div>
    </div>
    </div>
    
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
@stop
