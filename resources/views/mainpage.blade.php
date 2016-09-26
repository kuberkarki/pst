@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
{!! $selected_category['name'] !!}
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
         
        
             @if($selected_category->category_image__c)
            <header class="page-header page-header-banner" style="background-image:url({{ $selected_category->category_image__c }});">
        @else
            <header class="page-header page-header-banner" style="background-image:url(img/1400x220.png);">
        @endif
            <div class="container">
                <div class="page-header-banner-inner">

                    <h1 class="page-title">{!! $selected_category['name'] !!}</h1>
                    
                   
                </div>
            </div>
        </header>
        
        <div class="container">
         @include('common.notifications')
         {{Session::get('successful')}}
            <div class="row">
                <div class="col-md-3">
                    <aside class="category-filters">
                        <div class="category-filters-section">
                            <h3 class="widget-title-sm">Category</h3>
                            <ul class="cateogry-filters-list">
                                @foreach($categories as $category)
                                <li><a href="{{url('products/'.$category->id)}}">{{$category->name}}</a></li>
                                @endforeach
                                
                                
                            </ul>
                        </div>
                        
                    </aside>
                </div>
                <div class="col-md-9">
                    <div class="row" data-gutter="15">
                        @foreach ($products as $product)
                        <div class="col-md-4">
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
                        
                    </div>
                    
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
