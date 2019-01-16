<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>File Manager</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <script src="{{ asset('static/modules/lib/jquery.min.js') }}"></script>
        <script src="{{ asset('static/modules/lib/jquery-ui.js') }}"></script>

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
                    url : '{{ langRoute('admin.elfinder.connector') }}',  // connector URL
                    height: '100%',
                    commandsOptions: {
                        upload : {
                            ui : 'uploadbutton'
                        }
                    },
                    soundPath: '{{ asset($dir.'/sounds') }}',
                    uiOptions: {
                        toolbar: [
                            @if(request()->user('admin')->can('systemUpload'))
                            ['back', 'forward', 'up'], ['view', 'sort'], ['copy', 'cut', 'paste'], ['rm'],
                            ['duplicate', 'rename'], ['mkdir', 'upload'], ['getfile', 'open', 'download'], ['info'],
                            @else
                            ['back', 'forward', 'up'], ['view', 'sort'], ['getfile', 'open', 'download'], ['info'],
                            @endif
                        ]
                    },
                    contextmenu: {
                        cwd: [
                            @if(request()->user('admin')->can('systemUpload'))
                            'reload', '|', 'upload', 'mkdir', 'paste', '|', 'view', 'sort', 'selectall', '|', 'info',
                            @else
                            'reload', '|', 'view', 'sort', 'selectall', '|', 'info',
                            @endif
                        ],
                        files: [
                            @if(request()->user('admin')->can('systemUpload'))
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