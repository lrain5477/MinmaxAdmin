@extends('admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::render('edit'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('admin.form.edit')</h1>
        <div class="float-right">
            <a class="btn btn-sm btn-light" href="{{ route('admin.index', [$pageData->uri]) }}" title="@lang('admin.form.back_list')">
                <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
            </a>
        </div>
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="editForm" class="form-horizontal validate editForm"  name="editForm"
                  action="{{ route('admin.update', [$pageData->uri, $formDataId]) }}"
                  method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                @yield('forms')
            </form>
        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection