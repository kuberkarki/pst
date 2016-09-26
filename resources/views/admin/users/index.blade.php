@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Users List
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
                Users
            </h1>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="block">
        <div class="block-content ">
           
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>User E-mail</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                    	<tr>
                            <td>{!! $user->id !!}</td>
                    		<td>{!! $user->first_name !!}</td>
            				<td>{!! $user->last_name !!}</td>
            				<td>{!! $user->email !!}</td>
            				<td>
            					@if($activation = Activation::completed($user))
            						Activated
            					@else
            						Pending
            					@endif
            				</td>
            				<td>{!! $user->created_at->diffForHumans() !!}</td>
            				<td>
                                <a href="{{ route('users.show', $user->id) }}"><i class="fa fa-eye"></i></i></a>

                                <a href="{{ route('admin.users.edit', $user->id) }}"><i class="fa fa-edit"></i></a> 
                                
                                @if ((Sentinel::getUser()->id != $user->id) && ($user->id != 1))
                					<!-- <a href="{{ route('confirm-delete/user', $user->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-remove"></i></a> -->

                                   
                				@endif

                                
                            </td>
            			</tr>
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>    <!-- row-->
</section>
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