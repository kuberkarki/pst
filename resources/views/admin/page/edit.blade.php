@extends('admin/layouts/default')
@section('additionalstyles')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote/summernote.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/summernote/summernote-bs3.min.css') }}">
@endsection

@section('content')
<div class="content bg-gray-lighter">
	<div class="row items-push">
		<div class="col-sm-7">
			<h1 class="page-heading">Edit Page</h1>
		</div>
		<div class="col-sm-5 text-right hidden-xs">
			<ol class="breadcrumb push-10-t">
				<li>Pages</li>
				<li><a class="link-effect" href="">{{ $page->name }}</a></li>
			</ol>
		</div>
	</div>
</div>
<div class="content">
	@include('common.notifications')

	<div class="row">
		<div class="col-md-12">
			<div class="block">
				<div class="block-content block-content-full">
					<form class="form-horizontal js-validation-page" action="/admin/page/{{ $page->id }}" method="post">
						{!! csrf_field() !!}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label class="col-xs-12" for="name">Name</label>
							<div class="col-sm-12">
								<input class="form-control" type="text" id="name" name="name" value="{{ $page->name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12" for="name">Content</label>
							<div class="col-sm-12">
								<textarea class="js-summernote" id="content" name="content">{{ $page->content }}</textarea>
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
</div>
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