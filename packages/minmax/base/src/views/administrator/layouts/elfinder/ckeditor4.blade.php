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
            // Helper function to get parameters from the query string.
            function getUrlParam(paramName) {
                var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
                var match = window.location.search.match(reParam) ;

                return (match && match.length > 1) ? match[1] : '' ;
            }

            $().ready(function() {
                var funcNum = getUrlParam('CKEditorFuncNum');

                var elf = $('#elfinder').elfinder({
                    // set your elFinder options here
                    @if($locale)
                    lang: '{{ $locale }}', // locale
                    @endif
                    customData: { 
                        _token: '{{ csrf_token() }}'
                    },
                    url: '{{ langRoute('administrator.elfinder.connector') }}',  // connector URL
                    height: '100%',
                    commandsOptions: {
                        upload : {
                            ui : 'uploadbutton'
                        }
                    },
                    soundPath: '{{ asset($dir.'/sounds') }}',
                    uiOptions: {
                        toolbar: [
                            ['back', 'forward', 'up'], ['view', 'sort'], ['copy', 'cut', 'paste'], ['rm'],
                            ['duplicate', 'rename'], ['mkdir', 'upload'], ['getfile', 'open', 'download'], ['info']
                        ]
                    },
                    contextmenu: {
                        cwd: ['reload', '|', 'upload', 'mkdir', 'paste', '|', 'view', 'sort', 'selectall', '|', 'info'],
                        files: ['getfile', 'open', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'info']
                    },
                    getFileCallback : function(file) {
                        window.opener.CKEDITOR.tools.callFunction(funcNum, file.url.replace(/\\/g, '/'));
                        window.close();
                    }
                }).elfinder('instance');
            });
        </script>
    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
