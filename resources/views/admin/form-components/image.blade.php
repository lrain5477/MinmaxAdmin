<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-10">
        <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="" {{ $required === true ? 'required' : '' }} />
        <button class="btn btn-secondary" type="button" data-target="#{{ $id }}-modal" data-toggle="modal"><i class="icon-pictures"> </i> 媒體庫</button>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>
<div class="form-group row">
    <div class="col-sm-10 offset-sm-2">
        <div class="file-img-list" id="{{ $id }}-list">
            @foreach($images as $key => $image)
            <div class="card mr-2 d-inline-block ui-sortable-handle">
                <input type="hidden" name="{{ $name }}[]" value="{{ $image->path }}" required />
                <a class="thumb" href="{{ asset($image->path) }}" data-fancybox="">
                    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"><img src="{{ asset($image->path) }}"/></span>
                </a>
                <div class="form-row mt-1">
                    <div class="col-auto">
                        <div class="btn-group btn-group-sm justify-content-center">
                            <button class="btn btn-outline-default delBtn" type="button"><i class="icon-trash2"></i></button>
                        </div>
                    </div>
                    <div class="col">
                        <input class="form-control form-control-sm mb-1" type="text" name="{{ $altName }}[]" value="{{ $image->alt }}" placeholder="ALT Text" />
                    </div>
                </div>
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
                <h5 class="modal-title">媒體庫</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"></button><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <div id="{{ $id }}-elfinder"></div>
            </div>
        </div>
    </div>
</div>
{{-- 彈跳視窗 END --}}
{{-- 圖片小卡樣板 START --}}
<template id="{{ $id }}-template">
    <div class="card mr-2 d-inline-block ui-sortable-handle">
        <input type="hidden" name="{{ $name }}[]" value="#replace_path" required />
        <a class="thumb" href="#replace_path" data-fancybox="">
            <span class="imgFill imgLiquid_bgSize imgLiquid_ready"
                  style="background: url('#replace_path') center center no-repeat; background-size: cover;">
                <img src="#replace_path" style="display: none;" />
            </span>
        </a>
        <div class="form-row mt-1">
            <div class="col-auto">
                <div class="btn-group btn-group-sm justify-content-center">
                    <button class="btn btn-outline-default delBtn" type="button"><i class="icon-trash2"></i></button>
                </div>
            </div>
            <div class="col">
                <input class="form-control form-control-sm mb-1" type="text" name="{{ $altName }}[]" value="" placeholder="ALT Text" />
            </div>
        </div>
    </div>
</template>
{{-- 圖片小卡樣板 END --}}

@push('scripts')
<script>
(function($) {
    $(function() {
        $('#{{ $id }}-list').sortable({
            disabled: false,
            items: '.card',
            zIndex: 9999,
            opacity: 0.7,
            forceHelperSize: false,
            helper: 'clone',
            change: function(event, div) { div.placeholder.css({visibility: 'visible', background: '#cc0000', opacity: 0.2}) },
            stop : function(event, div) {},
        }).disableSelection();

        let elf_{{ str_replace('-', '_', $id) }} = $('#{{ $id }}-elfinder').elfinder({
            lang: 'zh_TW',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{ route('admin.elfinder.connector') }}',
            commands: elFinder.prototype._options.commands,
            soundPath: '{{ asset('packages/barryvdh/elfinder/sounds') }}',
            reloadClearHistory: true,
            resizable: false,
            rememberLastDir: false,
            height: '500px',
            uiOptions: {
                toolbar: [
                    ['back', 'forward'], ['reload'], ['home', 'up'], ['mkdir', 'mkfile', 'upload'], ['open', 'download'], ['info'],
                    ['copy', 'cut', 'paste'], ['rm'], ['duplicate', 'rename', 'edit', 'resize'], ['view', 'sort']
                ]
            },
            contextmenu: {
                files: ['open', 'quicklook', 'sharefolder', '|', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'importBut', '|', 'info']
            },
            handlers: {
                select: function (event, elfinderInstance) {}
            },
            getFileCallback: function (file) {
                if({{ $limit }} !== 0 && $('#{{ $id }}-list .card').length >= {{ $limit }}) {
                    $('#{{ $id }}-modal').modal('hide');
                    swal({
                        title: "已達到選擇上限",
                        text: "您最多只能選擇 {{ $limit }} 個檔案",
                        confirmButtonText: "確認",
                        confirmButtonClass: "btn-danger",
                        closeOnConfirm: true
                    });
                } else {
                    $('#{{ $id }}-list').append($('#{{ $id }}-template').html().replace(/#replace_path/g, '/' + file.path));
                }
            }
        }).elfinder('instance');
    });

    {{-- 刪除圖片 --}}
    $('body').delegate('#{{ $id }}-list .delBtn', 'click', function(){
        let $this = $(this);
        swal({
            title: "是否確認刪除",
            text: "您將刪除此檔案",
            type: "info",
            showCancelButton: true,
            cancelButtonText:'取消',
            confirmButtonText: "確認",
            confirmButtonClass: "btn-danger",
            closeOnConfirm: false
        },
        function(){
            $this.parents('.card').remove();
            swal("刪除完成!", "您的檔案已刪除", "success");
        });
    });
})(jQuery);
</script>
@endpush