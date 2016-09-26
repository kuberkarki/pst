@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('blogcategory/title.management')
@parent
@stop
@section('header_styles')
    
@stop

{{-- Content --}}
@section('content')
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Categories
            </h1>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
@include('notifications')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading clearfix">

                    
                    <div class="pull-right">
                    <a href="{{ URL::to('admin/category/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('blogcategory/table.id')</th>
                                    <th>@lang('blogcategory/table.name')</th>
                                    <th>no. of Products</th>
                                    <th>@lang('blogcategory/table.created_at')</th>
                                    <th>@lang('blogcategory/table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($categories))
                                @foreach ($categories as $bcategory)
                                    <tr>
                                        <td>{{{ $bcategory->id }}}</td>
                                        <td>{{{ $bcategory->title }}}</td>
                                        <td>{{ $bcategory->product()->count() }}</td>
                                        <td>{{{ $bcategory->created_at->diffForHumans() }}}</td>
                                        <td>
                                            <a href="{{{ URL::to('admin/category/' . $bcategory->id . '/edit' ) }}}"><i
                                                        class="fa fa-edit" data-name="edit" data-size="18" data-loop="true"
                                                        data-c="#428BCA" data-hc="#428BCA"
                                                        title="@lang('blogcategory/form.update-blog')"></i></a>

                                            @if($bcategory->product()->count())
                                                <a href="#" data-toggle="modal" data-target="#blogcategory_exists" data-name="{!! $bcategory->title !!}" class="blogcategory_exists">
                                                    <i class="fa fa-warning" data-name="warning-alt" data-size="18"
                                                       data-loop="true" data-c="#f56954" data-hc="#f56954"
                                                       title="@lang('blogcategory/form.blogcategoryexists')"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('confirm-delete/category', $bcategory->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                                    <i class="fa fa-close" data-name="remove-alt" data-size="18"
                                                       data-loop="true" data-c="#f56954" data-hc="#f56954"
                                                       title="Delete"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>

@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="blogcategory_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="blogcategory_exists" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    @lang('category/message.category_have_blog')
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
        $(document).on("click", ".blogcategory_exists", function () {

            var group_name = $(this).data('name');
            $(".modal-header h4").text( group_name+" category" );
        });</script>
@stop
