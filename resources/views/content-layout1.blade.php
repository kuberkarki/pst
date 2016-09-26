@extends('layouts/thebox')

{{-- Page title --}}
@section('title')
{!! $selected_category->name !!}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
@stop


{{-- Page content --}}
@section('content')
<div class="container">
            <header class="page-header">
                <h1 class="page-title">{!! $selected_category->name !!}</h1>
            </header>
            <div class="row">
                <div class="col-md-9">
                    <p class="lead">{!! $selected_category->attigo__category_description__c !!}</p>
                </div>
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-8">
                    @if($selected_category->attigo__category_image__c)
                    <img class="full-width" src="{{ $selected_category->attigo__category_image__c }}" alt="{!! $selected_category->name !!}" title="{!! $selected_category->name !!}" />
                    @endif
                </div>
                <div class="col-md-4">
                   {!! $selected_category->attigo__content_caterogry_text_1__c !!}
                </div>
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-6">
                    {!! $selected_category->attigo__content_caterogry_text_2__c !!}
                </div>
                <div class="col-md-6">
                    @if($selected_category->attigo__category_content_image_2_link__c)
                    <img class="full-width" src="{{ $selected_category->attigo__category_content_image_2_link__c }}" alt="{!! $selected_category->name !!}" title="{!! $selected_category->name !!}" />
                    @endif
                </div>
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-9">
                @if($selected_category->attigo__category_content_image_3_link__c)
                    <img class="full-width" src="{{ $selected_category->attigo__category_content_image_3_link__c }}" alt="{!! $selected_category->name !!}" title="{!! $selected_category->name !!}" />
                @endif
                </div>
                <div class="col-md-3">
                    {!! $selected_category->attigo__content_caterogry_text_3__c !!}
                </div>
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-6">
                    {!! $selected_category->attigo__content_caterogry_text_4__c !!}
                </div>
                <div class="col-md-6">
                @if($selected_category->attigo__category_content_image_4_link__c)
                    <img class="full-width" src="{{ $selected_category->attigo__category_content_image_4_link__c }}" alt="{!! $selected_category->name !!}" title="{!! $selected_category->name !!}" />
                @endif
                </div>
            </div>
            <div class="gap gap-small"></div>
        </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
   
@stop
