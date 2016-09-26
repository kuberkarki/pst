@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Order Now
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
 <!--    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/cart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/tabbular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-rating/bootstrap-rating.css') }}"> -->
    <!--end of page level css-->
@stop

{{-- Page content --}}
@section('content')
<div class="container">
  <header class="page-header">
      <h1 class="page-title">Checkout Order</h1>
  </header>
  @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
@include('common.notifications')
{{Session::get('successful')}}
  <div class="row row-col-gap" data-gutter="60">
                <div class="col-md-4">
                    <h3 class="widget-title">Order Info</h3>
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Lang</th>
                                    
                                    <th>QTY</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $item)
                    <tr>
                        
                        <td class="cart_description">
                            <a href="{{url('products/details/'.explode(':',$item->id)[0])}}">{{$item->name}}</a>
                           
                        </td>
                        <!-- <td class="cart_price">
                            <p>{{$item->price}} kr</p>
                        </td> -->
                        <td>
                          @if($item->languagestext)
                          {{$item->options->sellanguage}}
                               <!-- <form action="{{url('cart')}}" method="POST">
                               <input type="hidden" name="id" value="{{$item->id}}" />
                               <input type="hidden" name="update_language" value="true" />
                               <input name="_token" hidden value="{!! csrf_token() !!}" />
                                <select name="language" onchange="this.form.submit()">
                                @foreach($item->languages as $language)
                                    <option {{ $language==$item->options->sellanguage?"selected=selected":""}} value="{{$language}}">{{$language}}</option>
                                @endforeach
                                </select>
                                </form> -->
                          @endif
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                            

                                
                                {{$item->qty}}
                               
                            </div>
                        </td>
                        
                        <td class="cart_total">
                            <p class="cart_total_price">{{ number_format($item->subtotal,2,'.','') }}kr</p>
                           
                        </td>
                        
                    </tr>
                    
                    @endforeach
                            </tbody>
                        </table>
                   
                     
                      </div> 
                      <div class="gap"></div>

                      
                      <div class="box">
                      @if($sfsettings->attigo__enable_coupon_field__c)
                      <h4>Coupon</h4>
                      @if($coupon!='')
                      {!! Form::open(['url' => route('removecoupon'),'id'=>'frm1']) !!}
                        Code: 
                        <input type="submit" class="btn btn-default check_out" value="Remove Coupon" />
                         {!! Form::close() !!}
                        @else
                        {!! Form::open(['url' => route('applycoupon'),'id'=>'frm2']) !!}
                        Coupon Code: <input type="text" class="" name="coupon"/>
                        <input type="submit" class="btn btn-default check_out" value="Apply" style="padding: 4px 7px" />
                       {!! Form::close() !!}

                     @endif
                     @endif

                     @if($shipmentoptions && Cart::total())
                    <h4>Shipping</h4>
                      @foreach($shipmentoptions as $shipment)
                             
                               <label class="shipoptions {{$shipment->attigo__allowed_shipping_countries__c}}">
                               <input type="radio" data-item="{{$shipment->attigo__add_handling_cost_for_each_item__c}}"" data-order="{{$shipment->attigo__add_handling_cost_for_each_order_row__c}}" data-quantity="{{$total_item}}" data-name="{{$shipment->attigo__shipment_label__c}}"  name="shipmentoption" value="{{$shipment->attigo__shipment_price__c}}" class="shippingprice" {{ ($selectedshipment==$shipment->id)?'checked':''}}/> {{$shipment->attigo__shipment_label__c}}
                              
                              
                               </label><div class="shippingdescription" style="padding-left: 13px; display:none;">{{ $shipment->attigo__frontend_content__c }}</div><br/>

                            @endforeach

                     
                     
                    @endif
                     @if(!count($shipmentoptions))
                        <div class="alert alert-danger alert-dismissable">
                          {{ $sfsettings->attigo__no_available_shipping_option_text__c }}
                        </div>
                      @endif
                      </div>
                      <div class="gap"></div>
                      <div class="box">
                         @if($paymentoptions)
                            <h4>Payment</h4>
                            @foreach($paymentoptions as $paymentoption)
                                 <label class="paymentoptions {{$paymentoption->attigo__available_country__c}}">
                                 <input type="radio" data-method="{{ $paymentoption->attigo__payment_capture_method__c}}"  name="paymentoption" value="{{$paymentoption->name}}" class="paymentoption" checked="checked" /> {{$paymentoption->name}}
                                 </label><div class="paymentdescription" style="padding-left: 13px; display:none;">{{ $paymentoption->attigo__help_description__c }}</div><br/>

                                @endforeach
                          @endif

                          @if(!count($paymentoptions))
                            <div class="alert alert-danger alert-dismissable">
                              {{ $sfsettings->attigo__no_available_payment_option_text__c }}
                            </div>
                          @endif
                      </div>
                </div>
                <div class="col-md-4">
                    <h3 class="widget-title">Billng Details</h3>
                    <div class="form-group">
                      {!! Form::label('firstName', 'First Name:') !!}
                      {!! Form::text('first_name', $user->first_name, ['class' => 'form-control','disabled'=>'disabled']) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('lastName', 'Last Name:') !!}
                      {!! Form::text('last_name', $user->last_name, ['class' => 'form-control','disabled'=>'disabled']) !!}
                    </div>

                    <div class="form-group">
                      {!! Form::label('email', 'Email address:') !!}
                      {!! Form::email('email', $user->email, ['class' => 'form-control','disabled'=>'disabled', 'placeholder' => 'email@example.com']) !!}
                    </div>
                  {!! Form::open(['url' => route('order-post'),'id'=>'frm']) !!}
                
                  <h4>Shipping Information</h4>
                  <div class="checkbox">
                    <label><input name="attigo__temporary_shipping_address__c" type="checkbox" value="1" id="changeaddress">Change Shipping Address</label>
                  </div>
                  <div class="form-group">
                       {!! Form::label(null, 'Shipping Street:') !!}
                        {!! Form::text('shipping_street', $contact->account->shippingstreet, ['class' => 'disifnotchange form-control','disabled'=>'disabled']) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label(null, 'Shipping City:') !!}
                      {!! Form::text('shipping_city', $contact->account->shippingcity, ['class' => 'disifnotchange form-control' ,'disabled'=>'disabled']) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label(null, 'Shipping State:') !!}
                      {!! Form::text('shipping_state', $contact->account->shippingstate, ['class' => 'disifnotchange form-control' ,'disabled'=>'disabled']) !!}
                  </div>

                  <div class="form-group">
                     {!! Form::label(null, 'Shipping Country:') !!}
                      {!! Form::text('shipping_country', $contact->account->shippingcountry?$contact->account->shippingcountry:'Svergie', ['class' => 'disifnotchange form-control shipping_country' ,'disabled'=>'disabled']) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label(null, 'Shipping Postalcode:') !!}
                      {!! Form::text('shipping_postalcode', $contact->account->shippingpostalcode, ['class' => 'disifnotchange form-control' ,'disabled'=>'disabled']) !!}
                  </div>
                  <input type="hidden" class="shippingtotal" name="shippingtotal"/>
                  <input type="hidden" class="shippingdescription" name="shippingdescription"/>
                  <input type="hidden" id="payment" class="payment" name="attigo__e_com_payment_type__c"/>
                  <input type="hidden" id="paymentmethod" class="paymentmethod" name="attigo__e_com_order_method__c"/>
                </div>
                <div class="col-md-4">
                <h3 class="widget-title">Order Now</h3>
                     
                     @if(Cart::total())
                    <div class="col-md-6">
                    Total: 
                    </div>
                    <div>{{ number_format(Cart::total(),2,'.','') }}kr</div>
                     <div class="col-md-6">
                    Shipping Total: 
                    </div>
                    <div>
                    <span class="text" id="shippingdisplay"></span>
                    </div>
                      @if($discount_amount)
                      <div class="col-md-6">
                    Discount: 
                    </div>
                    <div>
                    <span class="text">-{{ number_format($discount_amount,2,'.','') }}kr</span>
                    </div>
                      @endif
                    @endif
                    
       
            </div>
      <div class="col-md-4">
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
     

      @if(Cart::total()<1)
      <div class="alert alert-danger alert-dismissable">
        Sorry, there is no item in cart.This order shall not be possible to place !!
      </div>
      @endif

      @if($sfsettings->attigo__manage_stock__c)
        @if(!$show_backorder || $sfsettings->attigo__allow_backorder__c)

      <div class="form-group">
            <input type="submit" onclick="$('#frm')[0].submit();" class="btn btn-primary" id="submitBtn"  value="Place Order!" {{ ((!count($shipmentoptions)) || (Cart::total()<1))?"disabled":""}} />
        </div>
        @endif
      @else
        <div class="form-group">
            <input type="button" onclick="#" class="btn btn-primary" id="submitBtn" value="Place Order!" {{ ((!count($shipmentoptions)) || (Cart::total()<1))?"disabled":""}} />
        </div>
        @endif

                    <!-- <img src="img/paypal.png" alt="Image Alternative text" title="Image Title" />
                    <p>Important: You will be redirected to PayPal's website to securely complete your payment.</p><a class="btn btn-primary">Pay With Paypal</a> -->
                </div>
            </div>
          </div>

           {!! Form::close() !!}
<div class="bg-primary-dark-op">
    <section class="content content-full content-boxed overflow-hidden">
        <!-- Section Content -->
        <div class="text-center">
           
           
        <!-- END Section Content -->
        </div>
    </section>
</div>

@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <!--page level js start-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-rating/bootstrap-rating.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/cart.js') }}"></script>
    <!--page level js start-->
  <script>
  $('#changeaddress').change(function(){
  if($(this).is(':checked')){
    $(".disifnotchange").each(function(){
      $(this).attr('disabled',false);
    });
  }else{
    $(".disifnotchange").each(function(){
      $(this).attr('disabled',true);
    });

  }

  //$('#changeaddress').attr('disabled',false);
  //$('#submitBtn').attr('disabled',false);
});


$('.shipoptions').hide();
$('.paymentoptions').hide();
var country=$('.shipping_country').val();
$('.'+country).show();
$('.shipping_country').change(function(){
  $('.shipoptions').hide();

  var country=$(this).val();
  $('.'+country).show();
});


$(document).ready(function() {
  $(":radio").each(function(){
    //alert(this.name)

    if ($(this).is(':checked')){
      
      var $this=$(this);
      var $class=($this.attr('class'));
      if($class=='shippingprice'){
       var $id=parseInt($(this).data("id"));
      
      var $item=parseFloat($(this).data("item"));
      var $order=parseFloat($(this).data("order"));
      var $quantity=parseFloat($(this).data("quantity"));
      var $totalshipping=(parseFloat($this.val())+($item*$quantity)+$order).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      //alert($totalshipping);
      $('#shippingdisplay').html("+"+$totalshipping+"kr").removeClass('hidden');
      //$('.shippinginput').val($totalshipping);
      $(".shippingtotal").val($totalshipping);
      $(".shippingdescription").val($(this).data('name'));
      $this.parent().next(".shippingdescription").show();
      //total();
      }
      if($class=='paymentoption'){
        $(".payment").val($this.val());
        $(".paymentmethod").val($(this).data("method"));
        $this.parent().next(".paymentdescription").show();
      }

    }


     
  });

  $('input[type=radio][name=shipmentoption]').change(function() {
      //alert("here")
     
      var $this=$(this);
      var $class=($this.attr('class'));
      var $item=parseFloat($(this).data("item"));
      var $order=parseFloat($(this).data("order"));
      var $quantity=parseFloat($(this).data("quantity"));
      var $totalshipping=(parseFloat($this.val())+($item*$quantity)+$order).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      //alert($item);
      //alert($totalshipping);
     $('#shippingdisplay').html("+"+$totalshipping+"kr").removeClass('hidden');
     // $('.shippinginput').val($totalshipping);
      $(".shippingtotal").val($totalshipping);
      $(".shippingdescription").val($(this).data('name'));
      $(".shippingdescription").hide();
      $this.parent().next(".shippingdescription").show();
       // total();
    });

  $('input[type=radio][name=paymentoption]').change(function() {
      var $this=$(this);
      $(".payment").val($this.val());
      $(".paymentmethod").val($(this).data("method"));
      $(".paymentdescription").hide();
      $this.parent().next(".paymentdescription").show();
      
    });


    
});
  </script>
@stop
