@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Products List
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
                Products</small>
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
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Description</th>

                             <th>isActive</th>
                            
                            
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                        
                            <td>{!! $product->sfid !!}</td>
                            <td>

                            
                            @if(isset($product->productsdetails))
                            
                            <img src="{!! Cloudder::show($product->productsdetails->thumbnail,array("width"=>150, "height"=>null, "crop"=>"fill", "fetch_format"=>"auto", "type"=>"upload")) !!}"/>
                            <br/>
                            <a href="{{ route('admin.product.generate', $product->id) }}">Regenerate</a>
                            @elseif($product->external_product_image__c=='')
                             No product image
                            @else
                                <a href="{{ route('admin.product.generate', $product->id) }}">Generate</a>
                            @endif
                            </td>
                            <td>{!! $product->name !!}</td>
                            <td>{!! $product->productcode !!}</td> 
                            <td>{!! $product->description !!}</td>
                            <td>{!! $product->isactive !!}</td>
                            
                            
                            
                            <td>
                                <a href="#"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view user"></i></a>
                                <a href="{{ route('admin.product.edit', $product->id) }}"><i class="fa fa-edit"></i></a>
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