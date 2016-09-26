@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('groups/title.edit')
@parent
@stop

{{-- Content --}}
@section('content')


<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">@lang('groups/title.groups')</h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Groups</li>
                <li><a class="link-effect" href="">@lang('groups/title.edit')</a></li>
            </ol>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="block">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <!-- <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('groups/title.edit')
                    </h4> -->
                </div>
                <div class="panel-body">
                    @if($role)
                        <form class="form-horizontal" role="form" method="post" action="">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group {{ $errors->
                                first('name', 'has-error') }}">
                                <label for="title" class="col-sm-2 control-label">
                                    @lang('groups/form.name')
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" id="name" name="name" class="form-control"
                                           placeholder=@lang('groups/form.name') value="{!! old('name', $role->
                                    name) !!}">
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slug" class="col-sm-2 control-label">@lang('groups/form.slug')</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" value="{!! $role->slug !!}" readonly />
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('groups') }}">
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
</section>

@stop