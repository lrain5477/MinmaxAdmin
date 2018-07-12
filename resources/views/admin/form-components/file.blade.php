<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-10">
        <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="" {{ $required === true ? 'required' : '' }} />
        <button class="btn btn-secondary" type="button" data-target="#{{ $id }}-modal" data-toggle="modal"><i class="icon-folder"> </i> @lang('admin.form.button.media_file')</button>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>
<div class="form-group row">
    <div class="col-sm-10 offset-sm-2">
        <div class="file-list" id="{{ $id }}-list">
            @foreach($files as $file)
            <div class="alert alert-info alert-dismissible fade show ui-sortable-handle" role="alert">
                <input type="hidden" name="{{ $name }}[]" value="{{ $file }}" required />
                {{ $file }} <a href="{{ asset($file) }}" class="alert-link" target="_blank"><i class="icon-popout"></i></a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- 彈跳視窗 START --}}
<div class="modal fade bd-example-modal-lg" id="{{ $id }}-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('admin.form.button.media_file')</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"></button><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <div id="{{ $id }}-elfinder"></div>
            </div>
        </div>
    </div>
</div>
{{-- 彈跳視窗 END --}}
{{-- 檔案項目樣板 START --}}
<template id="{{ $id }}-template">
    <div class="alert alert-info alert-dismissible fade show ui-sortable-handle" role="alert">
        <input type="hidden" name="{{ $name }}[]" value="#replace_path" required />
        #replace_path <a href="#replace_path" class="alert-link" target="_blank"><i class="icon-popout"></i></a>
        <button type="button" class="close delBtn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
</template>
{{-- 檔案項目樣板 END --}}

@push('scripts')
<script>
(function($) {
    $(function() {
        $('#{{ $id }}-list').sortable({
            disabled: false,
            items: '.alert',
            zIndex: 9999,
            opacity: 0.7,
            forceHelperSize: false,
            helper: 'clone',
            change: function(event, div) { div.placeholder.css({visibility: 'visible', background: '#cc0000', opacity: 0.2}) },
            stop : function(event, div) {},
        }).disableSelection();

        let elf_{{ str_replace('-', '_', $id) }} = $('#{{ $id }}-elfinder').elfinder({
            @switch(app()->getLocale())
                @case('tw')
                lang: 'zh_TW',
                @break
                @case('cn')
                lang: 'zh_CN',
                @break
                @case('jp')
                lang: 'ja',
                @break
            @endswitch
            customData: {
                _token: '{{ csrf_token() }}'
            },
            url: '{{ route('admin.elfinder.connector') }}',
            commands: elFinder.prototype._options.commands,
            commandsOptions: {
                upload : {
                    ui : 'uploadbutton'
                }
            },
            soundPath: '{{ asset('components/elFinder/sounds') }}',
            reloadClearHistory: true,
            resizable: false,
            rememberLastDir: false,
            height: '500px',
            uiOptions: {
                toolbar: [
                    @if(\Auth::guard('admin')->user()->can('systemUpload'))
                    ['back', 'forward', 'up'], ['view', 'sort'], ['copy', 'cut', 'paste'], ['rm'],
                    ['duplicate', 'rename'], ['mkdir', 'upload'], ['getfile', 'open', 'download'], ['info']
                    @else
                    ['back', 'forward', 'up'], ['view', 'sort'], ['getfile', 'open', 'download'], ['info']
                    @endif
                ]
            },
            contextmenu: {
                @if(\Auth::guard('admin')->user()->can('systemUpload'))
                cwd: ['reload', '|', 'upload', 'mkdir', 'paste', '|', 'view', 'sort', 'selectall', '|', 'info'],
                files: ['getfile', 'open', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'info']
                @else
                cwd: ['reload', '|', 'view', 'sort', 'selectall', '|', 'info'],
                files: ['getfile', 'open', 'download', 'info']
                @endif
            },
            getFileCallback: function (file) {
                if({{ $limit }} !== 0 && $('#{{ $id }}-list .alert').length >= {{ $limit }}) {
                    $('#{{ $id }}-modal').modal('hide');
                    swal({
                        title: "@lang('admin.form.elfinder.limit_title')",
                        text: "@lang('admin.form.elfinder.limit_text', ['limit' => $limit])",
                        confirmButtonText: "@lang('admin.form.elfinder.limit_confirm_button')",
                        confirmButtonClass: "btn-danger",
                        closeOnConfirm: true
                    });
                } else {
                    $('#{{ $id }}-list').append($('#{{ $id }}-template').html().replace(/#replace_path/g, '/' + file.path.replace(/\\/g, '/')));
                }
            }
        }).elfinder('instance');
    });
})(jQuery);
</script>
@endpush