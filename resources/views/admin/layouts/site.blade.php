<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>MINMAX 後台管理系統</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ asset('/admin/css/styles.css') }}">
    @stack('styles')
</head>
<body>
<div class="wrapper">
    @include('admin.layouts._header')

    <div class="border-box page-content">
        <div class="content-header">
            <div class="row justify-content-between">
                <div class="col-auto">
                    @yield('breadcrumbs')
                </div>
            </div>
        </div>

        <div class="content-body">
            @include('admin.layouts._alerts')

            @yield('content')
        </div>
    </div>

    @include('admin.layouts._sidebar')

    <footer class="page-footer small p-2">
        <p class="mb-0">{{ date('Y') }} © MINMAX. design by <a href="http://minmax.biz" target="_blank">MINMAX</a></p>
    </footer>
</div>

@include('admin.layouts._footJs')
</body>
</html>