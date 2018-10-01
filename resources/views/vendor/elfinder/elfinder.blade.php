<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>elFinder 2.0</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/themes/windows-10/css/theme.css') }}">

        <!-- elFinder JS (REQUIRED) -->
        <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

        @if($locale)
        <!-- elFinder translation (OPTIONAL) -->
        <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
        @endif

        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            // Documentation for client options:
            // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
            $().ready(function() {
                $('#elfinder').elfinder({
                    // set your elFinder options here
                    @if($locale)
                        lang: '{{ $locale }}', // locale
                    @endif
                    customData: { 
                        _token: '{{ csrf_token() }}'
                    },
                    url : '{{ langRoute("{$guard}.elfinder.connector") }}',  // connector URL
                    commandsOptions: {
                        upload : {
                            ui : 'uploadbutton'
                        }
                    },
                    soundPath: '{{ asset($dir.'/sounds') }}',
                    uiOptions: {
                        toolbar: [
                            @if($guard === 'administrator' || request()->user($guard)->can('systemUpload'))
                            ['back', 'forward', 'up'], ['view', 'sort'], ['copy', 'cut', 'paste'], ['rm'],
                            ['duplicate', 'rename'], ['mkdir', 'upload'], ['getfile', 'open', 'download'], ['info'],
                            @else
                            ['back', 'forward', 'up'], ['view', 'sort'], ['getfile', 'open', 'download'], ['info'],
                            @endif
                        ]
                    },
                    contextmenu: {
                        cwd: [
                            @if($guard === 'administrator' || request()->user($guard)->can('systemUpload'))
                            'reload', '|', 'upload', 'mkdir', 'paste', '|', 'view', 'sort', 'selectall', '|', 'info',
                            @else
                            'reload', '|', 'view', 'sort', 'selectall', '|', 'info',
                            @endif
                        ],
                        files: [
                            @if($guard === 'administrator' || request()->user($guard)->can('systemUpload'))
                            'getfile', 'open', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'info',
                            @else
                            'getfile', 'open', 'download', 'info',
                            @endif
                        ]
                    }
                });
            });
        </script>
    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
