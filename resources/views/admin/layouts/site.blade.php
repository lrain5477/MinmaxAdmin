<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ $webData->website_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('components/elFinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('components/elFinder/css/theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('components/elFinder/themes/windows-10/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
    @stack('styles')
</head>
<body>
<div class="wrapper">
    @include('admin.layouts.header')

    <div class="border-box page-content">
        <div class="content-header">
            <div class="row justify-content-between">
                <div class="col-auto">
                    @yield('breadcrumbs')
                </div>
            </div>
        </div>

        <div class="content-body">
            @include('admin.layouts.alerts')

            @yield('content')
        </div>
    </div>

    @include('admin.layouts.sidebar')

    <footer class="page-footer small p-2">
        <p class="mb-0">{{ date('Y') }} © {{ config('app.author') }}. design by <a href="{{ config('app.author_url') }}" target="_blank">{{ config('app.author') }}</a></p>
    </footer>
</div>

@include('admin.layouts.plugin')
</body>
</html>