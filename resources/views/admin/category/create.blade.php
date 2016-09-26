@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    @lang('blogcategory/title.create') :: @parent
@stop

{{-- Content --}}

@section('content')
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Edit Category
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
                    {!! Form::open(array('url' => URL::to('admin/category/create'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}
                    <div class="form-group {{ $errors->first('title', 'has-error') }}">
                        <label for="title" class="col-sm-2 control-label">
                            Name
                        </label>
                        <div class="col-sm-5">
                            {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>'Name')) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! $errors->first('title', '<span class="help-block">:message</span> ') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <a class="btn btn-danger" href="{{ URL::to('admin/category/') }}">
                                @lang('button.cancel')
                            </a>
                            <button type="submit" class="btn btn-success">
                                @lang('button.save')
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
