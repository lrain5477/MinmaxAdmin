<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <title></title>
    <link rel="Shortcut Icon" type="image/x-icon" href=""/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0 maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content=""/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="resource/fonts/style.css">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
    <div class="wp @yield('wp-class')" data-page-id="@yield('page-id')">

        {{-- header --}}
        @include('web.layouts.navbar')

        {{-- content --}}
        <div class="content">
            <h2 class="textHidden">Content</h2>
            @yield('main-content')
        </div>

        {{-- model --}}
        @yield('model-content')

        {{-- footer --}}
        @include('web.layouts.footer')
        
    </div>
    <!-- js -->
    @yield('script-content')
</body>
</html>