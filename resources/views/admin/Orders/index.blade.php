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
                Quick Delivery List</small>
            </h1>
        </div>
    </div>
</div>
<div class="content">
    @include('common.notifications')
    
    <div class="block">
        <div class="block-content">
        <div class="panel ">
            <div class="panel-heading">
               <!--  <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Products List
                </h4> -->
            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <!-- <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead> -->
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                        
                            <td>
    
                               
                                     
                              <h4> {{$order->email}}'s Order</h4>
                              {{$order->contact->firstname}} {{$order->contact->lastname}}<br/>
                                Phone: {{$order->contact->phone}}<br/>
                                Shipment type: {{$order->e_com_shipment__c}}<br/>
                                Org Nubmer:{{$order->account->org_number__c}}<br/>
                                Account Name: {{ $order->account->name }}<br/>
                                Payment Type:{{$order->e_com_payment_type__c}}
                              @if(count($order)==1)
                              
                                <table class="table">
                                    <tr>
                                      <td>Date</td>
                                      <td>{{$order->createddate}}</td>
                                    </tr>
                                    <tr>
                                      <td>Order Number</td>
                                      <td>{{ $order->ordernumber!=''?$order->ordernumber:$order->ecom_externalid_c__c }}</td>
                                    </tr>
                                    
                                    <!-- <tr>
                                      <td>Amount</td>
                                      <td>{{number_format($order->totalamount,2,'.','')}}</td>
                                    </tr>
                                    <tr>
                                      <td>Vat</td>
                                      <td>{{number_format($order->vat__c,2,'.','')}}</td>
                                    </tr>
                                    <tr>
                                      <td>Total</td>
                                      <td>{!! number_format((float)$order->totalamount+(float)$order->vat__c,2,'.','') !!}</td>
                                    </tr> -->
                                </table>

                                <h3>Products</h3>
                               
                                <table class="table">
                                      <tr>
                                        <td>Name</td>
                                        <td>Product Code</td>
                                        <td>Language</td>
                                        <td>Quantity</td>
                                        <td>Unit Price</td>
                                        <th>Vat(%)</th>
                                        <th>Line total</th>
                                      </tr>
                                    @foreach($order->summary as $summary)
                                      @if($summary['product_name']!='Shipping cost')
                                      <tr>
                                        <td><a href="{{url('products/details/'.$summary['product_id'])}}">{{$summary['product_name']}}</a></td>
                                        <td>{{$summary['product_code']}}</td>
                                        <td>{{$summary['language']}}</td>
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
                                      <td>{{number_format($order->shipping_cost,2,'.','')}} kr</td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td>Subtotal (excl Tax)</td>
                                      <td>{{number_format($order->totalamount,2,'.','')}} kr</td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td>Vat</td>
                                      <td>{{number_format($order->vat__c,2,'.','')}} kr</td>
                                    </tr>

                                    <tr>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td>Grand Total</td>
                                      <td>{!! number_format((float)$order->totalamount+(float)$order->vat__c,2,'.','') !!} kr</td>
                                    </tr>
                                </table>
                                
                                <h3>Shipping Address</h3>
                                <table class="table">
                                  <tr>
                                    <td>Shipping Street</td><td>{{$order->shippingstreet}}</td>
                                  </tr>
                                  <tr>
                                    <td>Shipping city</td><td>{{$order->shippingcity}}</td>
                                  </tr>
                                  <tr>
                                    <td>Shipping State</td><td>{{$order->shippingstate}}</td>
                                  </tr>
                                  <tr>
                                    <td>Shipping Country</td><td>{{$order->shippingcountry}}</td>
                                  </tr>
                                </table>
                                <h3>Billing Address</h3>
                                <table class="table">
                                  <tr>
                                    <td>Billing Street</td><td>{{$order->billingstreet}}</td>
                                  </tr>
                                  <tr>
                                    <td>Billing city</td><td>{{$order->billingcity}}</td>
                                  </tr>
                                  <tr>
                                    <td>Billing State</td><td>{{$order->billingstate}}</td>
                                  </tr>
                                  <tr>
                                    <td>Billing Country</td><td>{{$order->billingcountry}}</td>
                                  </tr>
                                </table>

                              @endif

                              <!-- <a class="btn btn-success" href="{{ route('admin.order.open', $order->id) }}"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Open">Open</i></a> -->
                                <a class="btn btn-success" href="{{ route('admin.order.deliver', $order->id) }}"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="Quick Deliver">Deliver</i></a>

  

                            </td>
                        </tr>
                        

                    @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
        </div>
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