@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Pages List
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
				Pages
			</h1>
		</div>
	</div>
</div>
<div class="content">
    @include('common.notifications')
    
    <div class="block">
        <div class="block-content">
			<form class="form-horizontal" method="post" action=" {{ URL::to('/admin/page/save-order')}}">
				{!! csrf_field() !!}
				<div class="form-group">
					<div class="col-xs-12">
						<button type="submit" class="btn btn-sm btn-primary">Save Order</button>
					</div>
				</div>
				
					<table class="table table-bordered " id="table">
						<thead >
							<tr class="filters">
								<th>Name</th>
								<th>Ordering</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if($pages->count())
							@foreach($pages as $page)
							<tr>
								<td>{{ $page->name }}</td>
								<td>
									<div class="row">
										<div class="col-xs-3">
											<input type="text" class="form-control" name="ordering[{{ $page->id }}]" value="{{ $page->order_by }}">
									  </div>
								  </div>
								</td>
								<td>
									<a class="btn btn-xs btn-primary" href="{{ URL::to('/admin/page/'.$page->id) }}/edit" title="Edit"><i class="fa fa-edit"></i></a>
									<button class="btn btn-xs btn-danger pageActionButton" data-actiontype="destroy" data-pageid="{{ $page->id }}" type="button" data-toggle="tooltip" data-original-title="Delete Page"><i class="fa fa-remove"></i></button>
								</td>
							</tr>
							 @endforeach
							 @if($totalPages > config('sitesettings.pagination.limit'))
							 <tr>
							 	<td colspan="3" align="right">{!! $pages->links() !!}</td>
							 </tr>
							 @endif
							 @else
							 <tr>
							 	<td colspan="3">No pages yet.</td>
							 </tr>
							 @endif
						</tbody>
					</table>
				
				<div class="form-group">
					<div class="col-xs-12">
						<button type="submit" class="btn btn-sm btn-primary">Save Order</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>






<div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content" style="padding:20px;">
                    <div class="block">
                        <div class="block-header bg-primary-dark">
                            
                            <h3 class="block-title">Confirmation</h3>
                        </div>
                        <div class="block-content">
                            <p>Are you sure you want to continue?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="/admin/page/do" method="post">
                        	{!! csrf_field() !!}
                        	<input type="hidden" name="page_id" id="pageActionField_pageId" value="" />
                        	<input type="hidden" name="action_type" id="pageActionField_actionType" value="" />
                        	<input type="hidden" name="redirect_url" id="pageActionField_redirectUrl" value="{{ url()->full() }}" />
                        	<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                        	<button class="btn btn-sm btn-primary" id="pageActionConfirmButton" type="submit"><i class="fa fa-check"></i> Ok</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('footer_scripts')
<script src="{{ asset('assets/js/admin/page.js') }}"></script>
@endsection