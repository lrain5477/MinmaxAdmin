<?php
/**
 * @var \Minmax\Base\Models\WebData $webData
 */
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ $webData->website_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('static/modules/elFinder/css/elfinder.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('static/modules/elFinder/css/theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('static/modules/elFinder/themes/windows-10/css/theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('static/admin/css/app.css') }}" rel="stylesheet" type="text/css" />
    @stack('styles')
</head>
<body>
<div class="wrapper">
    @include('MinmaxBase::administrator.layouts.header')

    <div class="border-box page-content">
        <div class="content-header">
            <div class="row justify-content-between">
                <div class="col-auto">
                    @yield('breadcrumbs')
                </div>
            </div>
        </div>

        <div class="content-body">
            @include('MinmaxBase::administrator.layouts.alerts')

            @yield('content')
        </div>
    </div>

    @include('MinmaxBase::administrator.layouts.sidebar')

    <footer class="page-footer small p-2">
        <p class="mb-0">{{ date('Y') }} © {{ config('app.author') }}. design by <a href="{{ config('app.author_url') }}" target="_blank">{{ config('app.author_en') }}</a></p>
    </footer>
</div>

@include('MinmaxBase::administrator.layouts.plugin')
</body>
</html>