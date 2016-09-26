@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
Order Now
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
<!--     <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/cart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-rating/bootstrap-rating.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/tabbular.css') }}">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
<div class="container">
  <header class="page-header">
      <h1 class="page-title">Confirmation</h1>
  </header>
   
    @include('common.notifications')
  <div class="col-md-10 col-md-offset-1">
    <div class="row">
      @if(count($orders)==1)
      {{$orders->creatdate}}
      To view your order details press 
      <a href="{{url('order-detail/'.$orders->id)}}" title="Order Detail">here</a>
      @endif
    </div>
  </div>
</div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!--page level js start-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/elevatezoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-rating/bootstrap-rating.js') }}"></script>
  
@stop
