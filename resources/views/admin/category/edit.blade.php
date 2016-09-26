@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('blog/title.edit')
@parent
@stop

{{-- Content --}}
@section('content')
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Create Category
            </h1>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                   
                </div>
                <div class="panel-body">
                    {!! Form::model($category, array('url' => URL::to('admin/category') . '/' . $category->id.'/edit', 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}
                    <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            <label for="title" class="col-sm-2 control-label">
                                Name
                            </label>
                            <div class="col-sm-5">
                                {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>trans('category/form.categoryname'))) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ URL::to('admin/blogcategory') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.update')
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>

@stop