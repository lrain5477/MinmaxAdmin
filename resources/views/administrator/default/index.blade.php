@extends('administrator.layouts.site')

@section('breadcrumbs', Breadcrumbs::render('index'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }}</h1>

        @yield('action-buttons')
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <div class="table-toolbar row">
                @yield('grid-filter')
            </div>

            @yield('grid-table')

        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection