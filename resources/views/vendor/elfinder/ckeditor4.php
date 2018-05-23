<!DOCTYPE html>
<html lang="<?= app()->getLocale() ?>">
    <head>
        <meta charset="utf-8">
        <title>elFinder 2.0</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/elfinder.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/themes/windows-10/css/theme.css') ?>">

        <!-- elFinder JS (REQUIRED) -->
        <script src="<?= asset($dir.'/js/elfinder.min.js') ?>"></script>

        <?php if($locale){ ?>
        <!-- elFinder translation (OPTIONAL) -->
        <script src="<?= asset($dir."/js/i18n/elfinder.$locale.js") ?>"></script>
        <?php } ?>
        
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
                    <?php if($locale){ ?>
                        lang: '<?= $locale ?>', // locale
                    <?php } ?>
                    customData: { 
                        _token: '<?= csrf_token() ?>'
                    },
                    url: '<?= route("{$guard}.elfinder.connector") ?>',  // connector URL
                    commandsOptions: {
                        upload : {
                            ui : 'uploadbutton'
                        }
                    },
                    soundPath: '<?= asset($dir.'/sounds') ?>',
                    uiOptions: {
                        toolbar: [
                            <?php if($guard === 'administrator' || \Auth::guard($guard)->user()->can('systemUpload')) { ?>
                            ['back', 'forward', 'up'], ['view', 'sort'], ['copy', 'cut', 'paste'], ['rm'],
                            ['duplicate', 'rename'], ['mkdir', 'upload'], ['getfile', 'open', 'download'], ['info']
                            <?php } else { ?>
                            ['back', 'forward', 'up'], ['view', 'sort'], ['getfile', 'open', 'download'], ['info']
                            <?php } ?>
                        ]
                    },
                    contextmenu: {
                        <?php if($guard === 'administrator' || \Auth::guard($guard)->user()->can('systemUpload')) { ?>
                        cwd: ['reload', '|', 'upload', 'mkdir', 'paste', '|', 'view', 'sort', 'selectall', '|', 'info'],
                        files: ['getfile', 'open', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'info']
                        <?php } else { ?>
                        cwd: ['reload', '|', 'view', 'sort', 'selectall', '|', 'info'],
                        files: ['getfile', 'open', 'download', 'info']
                        <?php } ?>
                    },
                    getFileCallback : function(file) {
                        window.opener.CKEDITOR.tools.callFunction(funcNum, '/' + file.path.replace(/\\/g, '/'));
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
