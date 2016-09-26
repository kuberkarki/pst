@extends('layouts/default')

{{-- Page title --}}
@section('title')
Order Now
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/cart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/tabbular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-rating/bootstrap-rating.css') }}">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
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
    <h3 class="text-primary">Confirmation</h3>
    @include('common.notifications')
  <div class="col-md-10 col-md-offset-1">
   

   

      
  <div class="row">
<h4> Your Order</h4>
  @if(count($orders)==1)
  <table class="table">
    <tr>
      <td>Order Number</td>
      <td>{{$orders->ordernumber}}</td>
    </tr>
    
    <tr>
      <td>Amount</td>
      <td>{{$orders->totalamount}}</td>
    </tr>
    <tr>
      <td>Vat</td>
      <td>{{$orders->vat__c}}</td>
    </tr>
    <tr>
      <td>Total</td>
      <td>{!! (float)$orders->totalamount+(float)$orders->vat__c !!}</td>
    </tr>

  </table>
    <h3>Products</h3>
   
      <table class="table">
          <tr>
            <td>Name</td>
            <td>Quantity</td>
            <td>Price</td>
          </tr>
        @foreach($orders->summary as $summary)
          @if($summary['product_name']!='Shipping cost')
          <tr>
            <td><a href="{{url('products/details/'.$summary['product_id'])}}">{{$summary['product_name']}}</a></td>
            <td>{{$summary['quantity']}}</td>
             <td>{{$summary['listprice']}}</td>
          </tr>
          @endif
        @endforeach
     </table>
    
    <h3>Shipping Address</h3>
    <table class="table">
      <tr>
        <td>Shipping Street</td><td>{{$orders->shippingstreet}}</td>
      </tr>
      <tr>
        <td>Shipping city</td><td>{{$orders->shippingcity}}</td>
      </tr>
      <tr>
        <td>Shipping State</td><td>{{$orders->shippingstate}}</td>
      </tr>
      <tr>
        <td>Shipping Country</td><td>{{$orders->shippingcountry}}</td>
      </tr>
    </table>
    <h3>Billing Address</h3>
    <table class="table">
      <tr>
        <td>Billing Street</td><td>{{$orders->billingstreet}}</td>
      </tr>
      <tr>
        <td>Billing city</td><td>{{$orders->billingcity}}</td>
      </tr>
      <tr>
        <td>Billing State</td><td>{{$orders->billingstate}}</td>
      </tr>
      <tr>
        <td>Billing Country</td><td>{{$orders->billingcountry}}</td>
      </tr>
    <table>

  @endif
  </div>

    
  </div>
  </div></div>
</div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!--page level js start-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-rating/bootstrap-rating.js') }}"></script>
  
@stop
