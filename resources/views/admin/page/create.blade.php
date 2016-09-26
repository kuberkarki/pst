@extends('admin/layouts/default')
{{-- Web site Title --}}
@section('title')
   Create Page
    @parent
@stop

@section('additionalstyles')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote/summernote.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote/summernote-bs3.min.css') }}">
@endsection

{{-- Content --}}
@section('content')
<div class="content bg-gray-lighter">
	<div class="row items-push">
		<div class="col-sm-7">
			<h1 class="page-heading">Edit Page</h1>
		</div>
		<div class="col-sm-5 text-right hidden-xs">
			<ol class="breadcrumb push-10-t">
				<li>Pages</li>
				<li><a class="link-effect" href="">New</a></li>
			</ol>
		</div>
	</div>
</div>



<section class="content">
@include('common.notifications')
	<div class="row">
		<div class="col-md-12">
			<div class="block">
				<div class="block-content block-content-full">
					<form class="form-horizontal js-validation-page" action="/admin/page" method="post">
						{!! csrf_field() !!}
						<div class="form-group">
							<label class="col-xs-12" for="name">Name</label>
							<div class="col-sm-12">
								<input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12" for="name">Content</label>
							<div class="col-sm-12">
								<textarea class="js-summernote" id="content" name="content">{{ old('content') }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<button class="btn btn-sm btn-primary" type="submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('additionaljs')
<script src="{{ asset('assets/js/plugins/summernote/summernote.min.js') }}"></script>
<script>
jQuery(function() {
	// Init page helpers (Summernote)
	App.initHelpers(['summernote']);
});
</script>
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/base_pages_page.js') }}"></script>
@endsection