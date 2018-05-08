@extends('admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('admin.layouts.breadcrumbs', 'view'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('admin.form.view')</h1>

        @yield('action-buttons')
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            @yield('views')
        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection