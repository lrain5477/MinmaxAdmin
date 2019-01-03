<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('MinmaxBase::admin.layouts.breadcrumbs', 'index'))

@section('content')
    <section class="panel panel-default">
        <header class="panel-heading">
            <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }}</h1>
        </header>

        <div class="panel-wrapper">
            <div class="panel-body">

                <div id="file-manager-elfinder"></div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function($) {
    $(function() {
        $('#file-manager-elfinder').elfinder({
            lang: '{{ app()->getLocale() == 'zh-Hant' ? 'zh_TW' : (app()->getLocale() == 'zh-Hans' ? 'zh_CN' : str_replace('-', '_', app()->getLocale())) }}',
            customData: {_token: '{{ csrf_token() }}'},
            url : '{{ langRoute('admin.elfinder.connector') }}',
            height: '700px',
            commandsOptions: {
                upload : {
                    ui : 'uploadbutton'
                }
            },
            soundPath: '{{ asset('static/modules/elFinder/sounds') }}',
            uiOptions: {
                toolbar: [
                    ['back', 'forward', 'up'], ['view', 'sort'], ['copy', 'cut', 'paste'], ['rm'],
                    ['duplicate', 'rename'], ['mkdir', 'upload'], ['getfile', 'open', 'download'], ['info']
                ]
            },
            contextmenu: {
                cwd: ['reload', '|', 'upload', 'mkdir', 'paste', '|', 'view', 'sort', 'selectall', '|', 'info'],
                files: ['getfile', 'open', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'info']
            }
        });
    });
})(jQuery);
</script>
@endpush