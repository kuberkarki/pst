@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Orders List
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Orders</small>
            </h1>
        </div>
    </div>
</div>
<div class="content">
    @include('common.notifications')
    
    <div class="block1">
         
        <h4> {{$orders->email}}'s Order</h4>
  @if(count($orders)==1)
  <table class="table">
    <tr>
      <td>Date</td>
      <td>{{$orders->createddate}}</td>
    </tr>
    <tr>
      <td>Order Number</td>
      <td>{{$orders->ordernumber}}</td>
    </tr>
    
    <tr>
      <td>Amount</td>
      <td>{{number_format($orders->totalamount,2,'.','')}}</td>
    </tr>
    <tr>
      <td>Vat</td>
      <td>{{number_format($orders->vat__c,2,'.','')}}</td>
    </tr>
    <tr>
      <td>Total</td>
      <td>{!! number_format((float)$orders->totalamount+(float)$orders->vat__c,2,'.','') !!}</td>
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

  <a href="{{ route('admin.order.deliver', $orders->id) }}" class="btn btn-success"><i  data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Deliver">Deliver</i></a>

    
  </div>
  </div></div>

    </div>
</div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

<script>
$(document).ready(function() {
	$('#table').DataTable();
});
</script>

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content"></div>
  </div>
</div>
<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop