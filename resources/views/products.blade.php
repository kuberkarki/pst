@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Products
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
         
        @if($selected_category->attigo__category_image__c)
            <header class="page-header page-header-banner" style="background-image:url({{ $selected_category->attigo__category_image__c }});">
        @else
            <header class="page-header page-header-banner" style="background-image:url(img/1400x220.png);">
        @endif
        
            <div class="container">
                <div class="page-header-banner-inner">

                    <h1 class="page-title">{{$selected_category->name}}</h1>
                    <p>{{ $selected_category->attigo__category_description__c }}</p>
                    
                </div>
            </div>
        </header>
        <div class="container">
         @include('common.notifications')
         {{Session::get('successful')}}
            <div class="row">
                <!-- <div class="col-md-3">
                    <aside class="category-filters">
                        <div class="category-filters-section">
                            <h3 class="widget-title-sm">Category</h3>
                            <ul class="cateogry-filters-list">
                                @foreach($categories as $category)
                                <li><a href="{{url('main-page/'.$category->id)}}">{{$category->name}}</a>
                                @endforeach
                                </li>
                                
                            </ul>
                        </div>
                        
                    </aside>
                </div> -->
                <div class="col-md-12">
                    <div class="row" data-gutter="15">
                        @foreach ($products as $product)
                        <div class="col-md-2">
                            <div class="product ">
                                <ul class="product-labels"></ul>
                                <div class="product-img-wrap">
                                    
                                    @if(isset($product->productsdetails->thumbnail))
                                            <img class="product-img" src='{{ Cloudder::show($product->productsdetails->thumbnail,array("width"=>202, "height"=>null, "crop"=>"fill", "fetch_format"=>"auto", "type"=>"upload"))}}' alt="{{ $product->name }}" title="Image Title" />
                                        @elseif(!$product->attigo__external_product_image__c)
                                        <img class="product-img" src="{{asset('/assets/img/thebox/500x500.png')}}" alt="{{$product->name }}" title="Image Title" />
                                        @else
                                        <img class="product-img" src="{{$product->attigo__external_product_image__c}}" alt="{{ $product->name }}" title="Image Title" />
                                        @endif
                                   <!--  <img class="product-img-alt" src="img/500x500.png" alt="Image Alternative text" title="Image Title" /> -->
                                </div>
                                <a class="product-link" href="{{url("products/details/$product->id")}}"></a>
                                <div class="product-caption">
                                    <!-- <ul class="product-caption-rating">
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
                                    </ul> -->
                                    <h5 class="product-caption-title">{{$product->name}}</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">{{$product->standardprice}} kr</span>
                                    </div>
                                    <!-- <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul> -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- <div class="col-md-4">
                            <div class="product ">
                                <ul class="product-labels">
                                    <li>hot</li>
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
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="product-caption-title">PUMA Faas 700 v2 Women's Running Shoes</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$147</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product ">
                                <ul class="product-labels">
                                    <li>hot</li>
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
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="product-caption-title">ASICS Women's GEL-Equation 7 Running Shoes T3F6N</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$147</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- <div class="row" data-gutter="15">
                        <div class="col-md-4">
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
                                    <h5 class="product-caption-title">Mizuno Wave Universe 5 Women's Running Shoes Sneakers</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$78</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>4 left</li>
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product ">
                                <ul class="product-labels">
                                    <li>-30%</li>
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
                                    <h5 class="product-caption-title">PUMA Cell Riaze Mesh Women's Running Shoes</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-old">$118</span><span class="product-caption-price-new">$83</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                    <h5 class="product-caption-title">ASICS Women's Gel-Noosa Tri 9 Running Shoe Black/Neon Coral/Green</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$124</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-gutter="15">
                        <div class="col-md-4">
                            <div class="product ">
                                <ul class="product-labels">
                                    <li>stuff pick</li>
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
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="product-caption-title">ASICS Women's 2015 LAM 33-DFA Running Shoes T55AQ</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$84</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product ">
                                <ul class="product-labels">
                                    <li>-50%</li>
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
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="product-caption-title">ASICS Women's GEL-Equation 7 Running Shoes T3F6N</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-old">$116</span><span class="product-caption-price-new">$58</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                    <h5 class="product-caption-title">PUMA Cell Riaze Mesh Women's Running Shoes</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$91</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-gutter="15">
                        <div class="col-md-4">
                            <div class="product ">
                                <ul class="product-labels">
                                    <li>-40%</li>
                                    <li>stuff pick</li>
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
                                        <li><i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <h5 class="product-caption-title">ASICS Women's Gel-Noosa Tri 9 Running Shoe Black/Neon Coral/Green</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-old">$103</span><span class="product-caption-price-new">$62</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>5 left</li>
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product ">
                                <ul class="product-labels">
                                    <li>hot</li>
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
                                    <h5 class="product-caption-title">PUMA Faas 700 v2 Women's Running Shoes</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$114</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                    <h5 class="product-caption-title">Mizuno Wave Universe 5 Women's Running Shoes Sneakers</h5>
                                    <div class="product-caption-price"><span class="product-caption-price-new">$106</span>
                                    </div>
                                    <ul class="product-caption-feature-list">
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row">
                        <div class="col-md-6">
                            <p class="category-pagination-sign">58 items found in Cell Phones. Showing 1 - 12</p>
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
                    </div> -->
                </div>
            </div>
        </div>
</div>
@stop
@section('contentold')
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
            <h3 class="text-primary">Books</h3>
        </div>
                    <!--main content-->
                    
         <!-- Notifications -->
        @include('common.notifications')

       {{Session::get('successful')}}

        <div class="col">
        <ul class="nav nav-pills">
                   @foreach($categories as $category)
                    <li {!! ($selected_category->id==$category->id ? 'class="active"' : '') !!}><a href="{{url('products/'.$category->id)}}">{{$category->name}}</a></li>
                   @endforeach
                </ul>
                
        </div>

        <div class="col">
            <div class="bg-primary-dark-op text-white">
                    <section class="content content-full content-boxed overflow-hidden">
                        <!-- Section Content -->
                        <div class="col-sm-12">
                        @if($selected_category->attigo__category_image__c)
                                                <img src="{{ $selected_category->attigo__category_image__c }}" alt="img"
                                                     class="img-responsive"/>
                                            @else
                                                <img src="http://placehold.it/1094x365?text={{$selected_category->name}}" alt="..."
                                                     class="img-responsive"/>
                                            @endif
                        </div> 
                        <div class="col-sm-12">
                           <p>{{ $selected_category->category_description__c }}</p>
                        </div>
                        <!-- END Section Content -->
                       
                    </section>
                </div>
        </div>



        <div class="col">
            
                <div class="features_items"><!--features_items-->
                
                    
                    @foreach ($products as $product)
                      <form method="POST" action="{{url('cart')}}">
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="thumbnail text-center">
                                     @if($product->attigo__external_product_image__c)
                                                <img src="{!! $product->attigo__external_product_image__c !!}" alt="img"
                                                     class="img-responsive"/>
                                            @else
                                                <img src="http://placehold.it/150x200" alt="..."
                                                     class="img-responsive"/>
                                            @endif
                                    <h2>{{$product->standardprice}} kr</h2>
                                    <h5 class="text-primary">{{$product->name}}</h5>
                                    
                                    
                                  
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-fefault add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                Add to cart
                                            </button>
                                        
                                    <a href='{{url("products/details/$product->id")}}' class="btn btn-default add-to-cart"><i class="fa fa-info"></i>View Details</a>
                                </div>
                                
                               
                            </div>
                            
                        </div>
                    </div>
                    </form>
                    @endforeach
                    <!-- <ul class="pagination">
                        <li class="active"><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">»</a></li>
                    </ul> -->
                </div><!--features_items-->
            </div>
          
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
