@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Home
@parent
@stop

{{-- page level styles --}}
@section('additionalstyles')
   
@stop

{{-- slider --}}
@section('top')
@stop

{{-- content --}}
@section('content')
   <div class="owl-carousel owl-loaded owl-nav-dots-inner" data-options='{"items":1,"loop":true}'>

    @foreach($blocks[1] as $block)
            <div class="owl-item">
                <div class="slider-item" style="{!! $block['bg'] or '' !!}">
                    <div class="container">
                        <div class="slider-item-inner">
                            <div class="slider-item-caption-{!! $block['caption_postion'] !!} slider-item-caption-white" style="color:{!! $block['caption_color']  or '#fff' !!};">
                                <h4 class="slider-item-caption-title">{{$block['caption'] or ''}}</h4>
                                <p class="slider-item-caption-desc">{{$block['caption_description'] or ''}}</p><a class="btn btn-lg btn-ghost btn-white" href="{{$block['link'] or '#'}}">{!! $block['link_button_text']  or 'Shop Now' !!}</a>
                            </div>
                            @if($block['foreground_image'])
                                <img class="slider-item-img-{!! $block['image_postion'] !!}" src="{!! $block['foreground_image'] !!}" alt="Image Alternative text" title="Image Title" style="max-width:200px;" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
            
   </div>
    <div class="row row-full" data-gutter="none">

        @foreach($blocks[2] as $block2)
            <div class="col-md-4">
                <div class="banner banner-o-hid banner-sqr" style="{!!$block2['bg'] or '' !!}">
                    <a class="banner-link" href="{!! $block2['link'] or '#'!!}"></a>
                    <div class="banner-caption-{!! $block2['caption_postion'] or  'left' !!} " style="color:{!! $block2['caption_color']  or '#fff' !!};">
                        <h5 class="banner-title" >{!! $block2['caption'] or '' !!}</h5>
                        <p class="banner-desc">{{$block2['caption_description'] or ''}}</p>
                        <p class="banner-shop-now">{!! $block2['link_button_text']  or 'Shop Now' !!} <i class="fa fa-caret-right"></i>
                        </p>
                    </div>
                    @if($block2['foreground_image'])
                    <img class="banner-img" src="{!! $block2['foreground_image'] !!}" alt="{{$block2['caption'] or '' }}" title="Image Title" style="{!! $block2['image_postion'] !!}" />
                    @endif
                </div>
            </div>
        @endforeach

        @foreach($blocks[3] as $block)
            <div class="col-md-4">
                <div class="banner banner-o-hid banner-sqr" style="{{$block['bg'] or ''}}">
                    <a class="banner-link" href="{!! $block['link'] or '#' !!}"></a>
                    <div class="banner-caption-{!! $block['caption_postion'] !!}" style="color:{!! $block['caption_color']  or '#fff' !!};">
                        <h5 class="banner-title" >{{$block['caption'] or ''}}</h5>
                        <p class="banner-desc">{{$block['caption_description'] or ''}}</p>
                        <p class="banner-shop-now">{!! $block['link_button_text']  or 'Shop Now' !!} <i class="fa fa-caret-right"></i>
                        </p>
                    </div>
                    @if($block['foreground_image'])
                    <img class="banner-img" src="{!! $block['foreground_image'] !!}" alt="{{$block['caption'] or ''}}" title="Image Title" style="{!! $block['image_postion'] !!}" />
                    @endif
                </div>
            </div>
        @endforeach


        @foreach($blocks[4] as $block)
            <div class="col-md-4">
                <div class="banner banner-o-hid banner-sqr" style="{{$block['bg'] or ''}}">
                    <a class="banner-link" href="{!! $block['link'] or '#' !!}"></a>
                    <div class="banner-caption-{!! $block['caption_postion'] !!}" style="color:{!! $block['caption_color']  or '#fff' !!};">
                        <h5 class="banner-title" >{{$block['caption'] or ''}}</h5>
                        <p class="banner-desc">{{$block['caption_description'] or ''}}</p>
                        <p class="banner-shop-now">{!! $block['link_button_text']  or 'Shop Now' !!} <i class="fa fa-caret-right"></i>
                        </p>
                    </div>
                    @if($block['foreground_image'])
                    <img class="banner-img" src="{!! $block['foreground_image'] !!}" alt="{{$block['caption'] or ''}}" title="Image Title" style="{!! $block['image_postion'] !!}" />
                    @endif
                </div>
            </div>
        @endforeach
            
        <div class="gap"></div>
        <div class="container">
            <div class="tabbable category-tabs">
                <ul class="nav nav-pills" id="myTab">
                @foreach($tabs_categories as $tab)
                    <li class="{{ $tab['class'] }}"><a href="#tab-{{ $tab['id'] }}" data-toggle="tab">{{ $tab['name'] }}</a>
                    </li>
                @endforeach
                    
                </ul>
                <div class="tab-content">
                    @foreach($tabs_categories as $tab)
                        <div class="tab-pane fade {{ $tab['class']!=''?'in active':'' }}" id="tab-{{ $tab['id'] }}">
                            <div class="row" data-gutter="15">
                            @foreach($tab['products'] as $product)
                                <div class="col-md-2">
                                    <div class="product product-sm ">
                                        <div class="product-img-wrap">
                                            @if(isset($product->productsdetails->thumbnail))
                                                <img class="product-img" src='{{ Cloudder::show($product->productsdetails->thumbnail,array("width"=>150, "height"=>null, "crop"=>"fill", "fetch_format"=>"auto", "type"=>"upload"))}}' alt="{{ $product->name }}" title="Image Title" />
                                            @elseif(!$product->attigo__external_product_image__c)
                                            <img class="product-img" src="{{asset('/assets/img/thebox/500x500.png')}}" alt="{{$product->name }}" title="Image Title" />
                                            @else
                                            <img class="product-img" src="{{$product->attigo__external_product_image__c}}" alt="{{ $product->name }}" title="Image Title" />
                                            @endif

                                        </div>
                                        <a class="product-link" href="{{url('products/details/'.$product->id)}}"></a>
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
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                            </ul> -->
                                            <h5 class="product-caption-title">{{ $product->name }}</h5>
                                            <div class="product-caption-price"><span class="product-caption-price-new">{{ $product->standardprice }} kr</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                               
                            </div>
                            
                        </div>
                    @endforeach


                </div>
            </div>
            <div class="gap"></div>
            <div class="row" data-gutter="15">
            @foreach($blocks[5] as $block)
                <div class="col-md-6">
                    <div class="banner banner-o-hid" style="{{$block['bg'] or ''}}">
                        <a class="banner-link" href="{!! $block['link'] or '#' !!}"></a>
                        <div class="banner-caption-{!! $block['caption_postion'] or 'left' !!} banner-caption-dark" style="color:{!! $block['caption_color']  or '#000' !!};">
                            <h5 class="banner-title" >{{$block['caption'] or ''}}</h5>
                            <p class="banner-desc">{{$block['caption_description'] or ''}}</p>
                            <p class="banner-shop-now">{!! $block['link_button_text']  or 'Shop Now' !!} <i class="fa fa-caret-right"></i>
                            </p>
                        </div>
                        @if($block['foreground_image'])
                        <img class="banner-img" src="{!! $block['foreground_image'] !!}" alt="{{$block['caption'] or ''}}" title="Image Title" style="{!! $block['image_postion'] !!}"  />
                        @endif
                    </div>
                </div>
            @endforeach

            @foreach($blocks[6] as $block)
                <div class="col-md-6">
                    <div class="banner banner-o-hid" style="{{$block['bg'] or ''}}">
                        <a class="banner-link" href="{!! $block['link'] or '#' !!}"></a>
                        <div class="banner-caption-{!! $block['caption_postion'] or 'left' !!} banner-caption-dark" style="color:{!! $block['caption_color']  or '#000' !!};">
                            <h5 class="banner-title" >{{$block['caption'] or ''}}</h5>
                            <p class="banner-desc">{{$block['caption_description'] or ''}}</p>
                            <p class="banner-shop-now">{!! $block['link_button_text']  or 'Shop Now' !!} <i class="fa fa-caret-right"></i>
                            </p>
                        </div>
                        @if($block['foreground_image'])
                        <img class="banner-img" src="{!! $block['foreground_image'] !!}" alt="{{$block['caption'] or ''}}" title="Image Title" style="{!! $block['image_postion'] !!}" />
                        @endif
                    </div>
                </div>
            @endforeach
                
            </div>
            <div class="gap"></div>
            @if(count($slide_products))
            <h3 class="widget-title">{{$slide_products['title']}}</h3>
            <div class="owl-carousel owl-loaded owl-nav-out" data-options='{"items":{{count($slide_products['products'])}},"loop":true,"nav":true}'>
                 @foreach($slide_products['products'] as $product)
                <div class="owl-item">
                    <div class="product product-sm owl-item-slide">
                        <div class="product-img-wrap">
                           @if(isset($product->productsdetails->thumbnail))
                                <img class="product-img" src='{{ Cloudder::show($product->productsdetails->thumbnail,array("width"=>150, "height"=>null, "crop"=>"fill", "fetch_format"=>"auto", "type"=>"upload"))}}' alt="{{ $product->name }}" title="Image Title" />
                            @elseif(!$product->attigo__external_product_image__c)
                            <img class="product-img" src="{{asset('/assets/img/thebox/500x500.png')}}" alt="{{$product->name }}" title="Image Title" />
                            @else
                            <img class="product-img" src="{{$product->attigo__external_product_image__c}}" alt="{{ $product->name }}" title="Image Title" />
                            @endif
                        </div>
                        <a class="product-link" href="{{url('products/details/'.$product->id)}}"></a>
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
                            <h5 class="product-caption-title">{{ $product->name }}</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">{{ $product->standardprice }} kr</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
            @endif
            <div class="gap"></div>
            
        </div>
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    
    <!--page level js ends-->

@stop
