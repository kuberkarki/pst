@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Cart
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
   <!--  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/price.css') }}">
<link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/> -->
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
<div class="container">
  <header class="page-header">
      <h1 class="page-title">My Shopping Bag</h1>
  </header>
@include('common.notifications')
{{Session::get('successful')}}
  <div class="row">
  <div class="col-md-10">
  <div class="table-responsive">
      <table class="table table table-shopping-cart">
          <thead>
              <tr>
                  <th>Product</th>
                  <th>Title</th>
                  <th>Language</th>
                  <th>Price</th>
                  <th>Quality</th>
                  <th>Total</th>
                  <th>Remove</th>
              </tr>
          </thead>
          <tbody>
            @foreach($cart as $item)
              <tr>
                  <td class="table-shopping-cart-img">
                      
                      @if($item->options->image)
                              <a href="{{url('products/details/'.explode(':',$item->id)[0])}}"><img  src="{{$item->options->image}}" alt=""></a>
                      @else
                          <a href="{{url('products/details/'.explode(':',$item->id)[0])}}"><img src="assets/img/default.png" alt=""></a>
                      @endif
                  </td>
                  <td class="table-shopping-cart-title"><a href="{{url('products/details/'.explode(':',$item->id)[0])}}">{{$item->name}}</a>
                  </td>
                  <td>
                    @if($item->languagestext)
                       <form action="{{url('cart')}}" method="POST">
                       <input type="hidden" name="id" value="{{$item->id}}" />
                       <input type="hidden" name="update_language" value="true" />
                       <input name="_token" hidden value="{!! csrf_token() !!}" />
                        <select name="language" class="product-page-option-select" onchange="this.form.submit()">
                        @foreach($item->languages as $language)
                            <option {{ $language==$item->options->sellanguage?"selected=selected":""}} value="{{$language}}">{{$language}}</option>
                        @endforeach
                        </select>
                        </form>
                    @endif
                  </td>
                  <td>{{number_format($item->price,2,'.','')}}kr</td>
                  <td>
                      <a class="cart_quantity_up" href='{{url("cart?product_id=$item->id&increment=1")}}'> + </a>
                      <input class="cart_quantity_input" type="text" name="quantity" value="{{$item->qty}}" autocomplete="off" size="2" style="text-align:center;">
                      <a class="cart_quantity_down" href='{{url("cart?product_id=$item->id&decrease=1")}}'> - </a>
                  </td>
                  <td>{{number_format($item->subtotal,2,'.','') }}kr</td>
                  <td>
                      
                      <a class="fa fa-close table-shopping-remove cart_quantity_delete" href='{{url("cart?product_id=$item->id&remove=1")}}'></a>
                  </td>
              </tr>
              <tr>
                      <td colspan="7">
                      <?php  if(in_array($item->options->originalid,$backorder_products)){
                            ?>
                            @if($sfsettings->attigo__manage_stock__c)
                              @if($show_backorder)
                                @if($sfsettings->attigo__allow_backorder__c)
                                  <div class="alert alert-warning alert-dismissable">
                                      {{$sfsettings->attigo__backorder_information_text__c}}
                                    </div>
                                @else
                                 <div class="alert alert-danger alert-dismissable">
                                      Sorry, We don't have enough quantity in stock.
                                    </div>
                                @endif
                              @endif
                              @endif
                            <?php
                      }
                        ?>
                          
                        </td>
                    </tr>
            @endforeach
          </tbody>
      </table>
  </div>
      <div class="gap gap-small"></div>
 @if($sfsettings->attigo__enable_coupon_field__c)
      @if($coupon!='')
  {!! Form::open(['url' => route('removecoupon'),'id'=>'frm']) !!}
    Coupon Code: 
    <input type="submit" class="btn btn-default check_out" value="Remove Coupon" />
     {!! Form::close() !!}
    @else
    {!! Form::open(['url' => route('applycoupon'),'id'=>'frm']) !!}
    Coupon Code: <input type="text" class="" name="coupon"/>
    <input type="submit" class="btn btn-default check_out" value="Apply Coupon" />
   {!! Form::close() !!}
  @endif

 @endif
 <div class="gap gap-small"></div>
 <a class="btn btn-default update" href="{{url('clear-cart')}}">Clear Cart</a>
  </div>
  <div class="col-md-2">
      @if(!count($shipmentoptions))
          <div class="alert alert-danger alert-dismissable">
          {{ $sfsettings->attigo__no_available_shipping_option_text__c }}
          </div>
      @endif

      @if($sfsettings->attigo__manage_stock__c)
        @if(!$show_backorder || $sfsettings->attigo__allow_backorder__c)
            <div class="col">

            @if($shipmentoptions && Cart::total())
              <h4>Shipping</h4>
              
                @foreach($shipmentoptions as $shipment)
                 <label class="shipoptions {{$shipment->attigo__allowed_shipping_countries__c}}">
                 <input type="radio" data-id="{{$shipment->id}}" data-item="{{$shipment->attigo__add_handling_cost_for_each_item__c}}" data-order="{{$shipment->attigo__add_handling_cost_for_each_order_row__c}}" data-quantity="{{$total_item}}" data-name="{{$shipment->attigo__shipment_label__c}}"  name="shipmentoption" value="{{$shipment->attigo__shipment_price__c}}" class="shippingprice" checked/> {{$shipment->attigo__shipment_label__c}} </label><br/>
                @endforeach
            @endif
            </div>
            <div>
            
            {!! Form::open(['url' => route('checkout'),'id'=>'frm']) !!}
            <ul class="shopping-cart-total-list">
                <li><span>Subtotal</span><span>{{number_format(Cart::total(),2,'.','')}} kr</span>
                </li>
                @if(count($shipmentoptions))
                  <li><div class="text" id="shippingdisplay"></div></li>
                @endif
                @if($discount_amount)
                  <li>
                    <span>Discount</span>
                    <span class="text">-{{$discount_amount}}kr</span>
                  </li>
                @endif
               <!--  <li><span>Total</span><span>$2199</span>
                  </li> -->
            </ul>
            
            <input type="submit" class="btn btn-primary check_out" value="Checkout" />
            <input type="hidden" class="shipment" name="shipment" />
          
          {!! Form::close() !!}
        @endif


      <!--------------------- -->
      @else
  <div class="col">

@if($shipmentoptions && Cart::total())
                    <h4>Shipping</h4>
                      @foreach($shipmentoptions as $shipment)
                             
                               <label class="shipoptions {{$shipment->attigo__allowed_shipping_countries__c}}">
                               <input type="radio" data-id="{{$shipment->id}}" data-item="{{$shipment->attigo__add_handling_cost_for_each_item__c}}" data-order="{{$shipment->attigo__add_handling_cost_for_each_order_row__c}}" data-quantity="{{$total_item}}" data-name="{{$shipment->attigo__shipment_label__c}}"  name="shipmentoption" value="{{$shipment->attigo__shipment_price__c}}" class="shippingprice" checked/> {{$shipment->attigo__shipment_label__c}}</label><br/>
                            @endforeach

                     
                     
                    @endif
</div>


  <div>


        <ul class="shopping-cart-total-list">                      
            <li><span>Subtotal</span> <span>{{ number_format(Cart::total(),2,'.','')}}kr</span></li>
            @if(count($shipmentoptions))
            <li><div class="text" id="shippingdisplay"></div></li>
            @endif
             @if($discount_amount)
               <li>
              Discount: 
              <span class="text">-{{ number_format($discount_amount,2,'.','')}}kr</span>
              </li>
              @endif
        </ul>

       
        <!-- <a class="btn btn-default check_out" href="{{url('order')}}">Check Out</a>
        <input type="text" class="shipment" name="shipment" /> -->
        {!! Form::open(['url' => route('checkout'),'id'=>'frm']) !!}
         
        <input type="submit" class="btn btn-default check_out" value="Check Out" />
        <input type="hidden" class="shipment" name="shipment" />
        {!! Form::close() !!}
        
       
  @endif

     
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
    $(document).ready(function() {
  $(":radio").each(function(){
    //alert(this.name)

    if ($(this).is(':checked')){
      
      var $this=$(this);
      var $class=($this.attr('class'));
       var $id=parseInt($(this).data("id"));
      var $item=parseFloat($(this).data("item"));
      var $order=parseFloat($(this).data("order"));
      var $quantity=parseFloat($(this).data("quantity"));
      var $totalshipping=(parseFloat($this.val())+($item*$quantity)+$order).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;;
      //alert($totalshipping);
      $('#shippingdisplay').html("<span style=\"width: 50%;float: left;\">Shipping</span><span style=\"width: 50%;float: left;\"> +"+$totalshipping+"kr</span>").removeClass('hidden');
      //$('.shippinginput').val($totalshipping);
     // $(".shippingtotal").val($totalshipping);
     // $(".shippingdescription").val($(this).data('name'));
     $(".shipment").val($id);
     // $(".check_out").attr("href","{{url('order')}}?shipment="+$id);
      //total();
    }


     
  });

  $('input[type=radio][name=shipmentoption]').change(function() {
      //alert("here")
     
      var $this=$(this);
      var $class=($this.attr('class'));
      var $id=parseFloat($(this).data("id"));
      var $item=parseFloat($(this).data("item"));
      var $order=parseFloat($(this).data("order"));
      var $quantity=parseFloat($(this).data("quantity"));
      var $totalshipping=(parseFloat($this.val())+($item*$quantity)+$order).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;;
      //alert($item);
      //alert($totalshipping);
     $('#shippingdisplay').html("<span style=\"width: 50%;float: left;\">Shipping</span><span style=\"width: 50%;float: left;\">+"+$totalshipping+"kr</span>").removeClass('hidden');
     // $('.shippinginput').val($totalshipping);
      //$(".shippingtotal").val($totalshipping);
      //$(".shippingdescription").val($(this).data('name'));
       // total();
        $(".check_out").attr("href","{{url('order')}}?shipment="+$id);

    });
//total();
/*function total() {
    var sum = 0;
    $(".qty1").each(function(){
        sum += +$(this).val();
    });
    $(".shippingtotal").val(sum);
}*/

    
});

//alert($('input[name=shipmentoption]:checked').val())



    
  </script>

@stop
