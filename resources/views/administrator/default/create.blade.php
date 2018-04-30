@extends('administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::render('create'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('administrator.form.create')</h1>
        <div class="float-right">
            <a class="btn btn-sm btn-light" href="{{ route('index', [$pageData->uri]) }}" title="@lang('administrator.form.back_list')">
                <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
            </a>
        </div>
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="createForm" class="form-horizontal validate createForm"  name="createForm"
                  action="{{ route('store', [$pageData->uri]) }}"
                  method="post"
                  enctype="multipart/form-data">
                @csrf

                @yield('forms')
            </form>
        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection