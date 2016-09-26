@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Order Detail
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
<div class="container">
  <header class="page-header">
      <h1 class="page-title">Order Detail</h1>
  </header>
    @include('common.notifications')
  
    <h4> Your Order</h4>
    @if(count($orders)==1)
    <div class="row">
      <div class=" col-md-12 table-responsive">
        <table class="table table-bordered table-striped">
          <tr>
            <td class="col-md-2">Order Number</td>
            <td class="col-md-4">{{$orders->ordernumber!=''?$orders->ordernumber:$orders->attigo__ecom_externalid_c__c}}</td>
            <td class="col-md-2">Date</td>
            <td class="col-md-4">{{$orders->createddate}}</td>
          </tr>
          <tr>
            <td>Account Name</td>
            <td>{{ $orders->account->name }}</td>
            <td>Shipment Type</td>
            <td>{{$orders->attigo__e_com_shipment__c}}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>{{$orders->email}}</td>
            <td>Payment Type</td>
            <td>{{$orders->attigo__e_com_payment_type__c}}</td>
          </tr>
          <tr>
            <td>Name</td>
            <td>{{$orders->contact->firstname}} {{$orders->contact->lastname}}</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>Phone</td>
            <td>{{$orders->contact->phone}}</td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
    </div>

  <div class="gap"></div>
  
   <div class="row">
     <div class="col-md-6"><h3>Shipping Address</h3>
     <div class="table-responsive">
      <div>
        <table class="table table-bordered table-striped">
          @if($orders->shippingstreet)
          <tr>
            <td>Shipping Street</td><td>{{$orders->shippingstreet}}</td>
          </tr>
          @endif
          @if($orders->shippingpostalcode)
          <tr>
            <td>Shipping city</td><td>{{$orders->shippingpostalcode}}</td>
          </tr>
          @endif
          @if($orders->shippingcity)
          <tr>
            <td>Shipping city</td><td>{{$orders->shippingcity}}</td>
          </tr>
          @endif
          @if($orders->shippingstate)
          <tr>
            <td>Shipping State</td><td>{{$orders->shippingstate}}</td>
          </tr>
          @endif
          @if($orders->shippingcountry)
          <tr>
            <td>Shipping Country</td><td>{{$orders->shippingcountry}}</td>
          </tr>
          @endif
          
        </table>
      </div>
      </div>
      </div>
     <div class="col-md-6">
     <div class="table-responsive">
     <div><h3>Billing Address</h3>
        <table class="table  table-bordered table-striped">

          @if($orders->billingstreet)
          <tr>
            <td>Billing Street</td><td>{{$orders->billingstreet}}</td>
          </tr>
          @endif
          @if($orders->billingpostalcode)
          <tr>
            <td>Billing zip</td><td>{{$orders->billingpostalcode}}</td>
          </tr>
          @endif
          @if($orders->billingcity)

          <tr>
            <td>Billing city</td><td>{{$orders->billingcity}}</td>
          </tr>
          @endif
          @if($orders->billingstate)
          <tr>
            <td>Billing State</td><td>{{$orders->billingstate}}</td>
          </tr>
          @endif
          @if($orders->billingcountry)
          <tr>
            <td>Billing Country</td><td>{{$orders->billingcountry}}</td>
          </tr>
          @endif
          
        </table>
      </div>
      </div>
    </div>
  </div>
  <div class="gap"></div>


  <h3>Products</h3>
     <div class="table-responsive">
        <table class="table table-bordered table-striped">
             <thead>  
              <tr>
                <th>Name</th>
                <th>Product Code</th>
                 <th>Option</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Vat(%)</th>
                <th>Line total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders->summary as $summary)
                @if($summary['product_name']!='Shipping cost')
                <tr>
                  <td><a href="{{url('products/details/'.$summary['product_id'])}}">{{$summary['product_name']}}</a></td>
                   <td>{!! $summary['product_code'] !!}</td>
                  <td>{!! $summary['language'] !!}</td>
                  <td>{{$summary['quantity']}}</td>
                   <td>{{ $summary['listprice']>0?number_format($summary['listprice'],2,'.','')." kr":'Free'}}</td>
                   <td>{{$summary['vat_pc']}}</td>
                   <td>{{$summary['listprice']*$summary['quantity']+($summary['listprice']*$summary['quantity'])*$summary['vat_pc']*.01 }} kr</td>
                </tr>
                @endif
              @endforeach
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Shipping</td>
                <td>{{number_format($orders->shipping_cost,2,'.','')}} kr</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Subtotal (excl Tax)</td>
                <td>{{number_format($orders->totalamount,2,'.','')}} kr</td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Vat</td>
                <td>{{number_format($orders->attigo__vat__c,2,'.','')}} kr</td>
              </tr>

              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Grand Total</td>
                <td>{!! number_format((float)$orders->totalamount+(float)$orders->attigo__vat__c,2,'.','') !!} kr</td>
              </tr>
          </tbody>
       </table>
       </div>
       <div class="gap"></div>
      
      

    @endif
  </div>
 </div> 

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!--page level js start-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-rating/bootstrap-rating.js') }}"></script>
  
@stop
