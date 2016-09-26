@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Edit Product
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/pages/wizard.css') }}" rel="stylesheet">
<!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">Edit Product</h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Product</li>
                <li><a class="link-effect" href="">{{ $product->name }}</a></li>
            </ol>
        </div>
    </div>
</div>
<section class="content">
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <!-- <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Edit Product
                    </h4> -->
                </div> 
                <div class="panel-body">
                    @if($product)
                        <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            

                           <div class="form-group">
                                <label class="col-md-2 control-label">Product Pic:</label>
                                <div class="col-md-10">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
                                            @if($product->external_product_image__c)
                                                <img src="{!! $product->external_product_image__c !!}" alt="img"
                                                     class="img-responsive"/>
                                            @else
                                                <img src="http://placehold.it/200x150" alt="..."
                                                     class="img-responsive"/>
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="file" id="file" />
                                                            </span>
                                            <span class="btn btn-primary fileinput-exists" data-dismiss="fileinput">Remove</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('admin.product') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.save')
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                        <h1>@lang('groups/message.no_role_exists')</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/edituser.js') }}"></script>
@stop