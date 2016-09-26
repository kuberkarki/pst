@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Attigo One
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('assets/vendors/fullcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css"/>
   <!--  <link href="{{ asset('assets/css/pages/calendar_custom.css') }}" rel="stylesheet" type="text/css"/> -->
    <link rel="stylesheet" media="all" href="{{ asset('assets/vendors/bower-jvectormap/css/jquery-jvectormap-1.2.2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendors/animate/animate.min.css') }}">
<!--     <link rel="stylesheet" href="{{ asset('assets/css/pages/only_dashboard.css') }}"/>
 -->    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

@stop

{{-- Page content --}}
@section('content')
<!-- Page Header -->
<div class="content bg-image overflow-hidden" style="background-image: url('{{ asset('assets/img/photos/photo3@2x.jpg') }}');">
    <div class="push-50-t push-15">
       <!--  <h1 class="h2 text-white animated zoomIn">Dashboard</h1> -->
        <h2 class="h5 text-white-op animated zoomIn">Welcome</h2>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
   <!--  <p>Dashboard</p> -->
</div>
<!-- END Page Content -->

@endsection @section('additionaljs')
<!-- <script src="{{ asset('assets/js/pages/base_pages_dashboard.js') }}"></script>
 -->@endsection


