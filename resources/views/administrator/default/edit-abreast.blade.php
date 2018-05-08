@extends('administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('administrator.layouts.breadcrumbs', 'edit'))

@section('content')
<!-- layout-content-->
<div class="row">
    <div class="col-xl-6">
        <section class="panel panel-default">
            <header class="panel-heading">
                <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('administrator.form.edit')</h1>
                <div class="float-right">
                    <a class="btn btn-sm btn-light" href="{{ route('administrator.index', [$pageData->uri]) }}" title="@lang('administrator.form.back_list')">
                        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
                    </a>
                </div>
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    <form id="editForm" class="form-horizontal validate editForm"  name="editForm"
                          action="{{ route('administrator.update', [$pageData->uri, $formData->guid]) }}"
                          method="post"
                          enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        @yield('forms')
                    </form>
                </div>
            </div>
        </section>
    </div>
    <div class="col-xl-6">
        <section class="panel panel-default">
            <header class="panel-heading">
                <h1 class="h5 float-left font-weight-bold">@lang('administrator.form.record')</h1>
            </header>

            <div class="panel-wrapper">
                <div class="panel-body">
                    @yield('records')
                </div>
            </div>
        </section>
    </div>
</div>
<!-- / layout-content-->
@endsection