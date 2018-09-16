<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var array $value
 * @var array $images
 *
 * Options
 * @var bool $required
 * @var integer $limit
 * @var string $hint
 * @var string $lang
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-10">
        <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="" {{ $required === true ? 'required' : '' }} {{ count($images) > 0 ? 'disabled' : '' }} />
        <button class="btn btn-secondary" type="button" data-target="#{{ $id }}-modal" data-toggle="modal"><i class="icon-pictures"> </i> @lang('administrator.form.button.media_image')</button>
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
                <input type="hidden" name="{{ $name }}[{{ $loop->index }}][path]" value="{{ $image['path'] }}" required />
                <a class="thumb" href="{{ asset($image['path']) }}" data-fancybox="">
                    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"><img src="{{ asset($image['path']) }}"/></span>
                </a>
                <div class="form-row mt-1">
                    <div class="col-auto">
                        <div class="btn-group btn-group-sm justify-content-center">
                            <button class="btn btn-outline-default delBtn" type="button"><i class="icon-trash2"></i></button>
                        </div>
                    </div>
                    <div class="col">
                        <input class="form-control form-control-sm mb-1" type="text" name="{{ $name }}[{{ $loop->index }}][alt]" value="{{ $image['alt'] }}" placeholder="ALT Text" />
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- 圖片小卡樣板 START --}}
<template id="{{ $id }}-template">
    <div class="card mr-2 d-inline-block ui-sortable-handle">
        <input type="hidden" class="card-path" name="{{ $name }}[][path]" value="#replace_path" required />
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
                <input class="form-control form-control-sm mb-1 card-alt" type="text" name="{{ $name }}[][alt]" value="" placeholder="ALT Text" />
            </div>
        </div>
    </div>
</template>
{{-- 圖片小卡樣板 END --}}

@push('scripts')
{{-- 彈跳視窗 START --}}
<div class="modal fade bd-example-modal-lg" id="{{ $id }}-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('administrator.form.button.media_image')</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"></button><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <div id="{{ $id }}-elfinder"></div>
            </div>
        </div>
    </div>
</div>
{{-- 彈跳視窗 END --}}
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
            stop : function(event, div) {
                $('#{{ $id }}-list .card').each(function() {
                    let inputName = '{{ $name }}';
                    let $this = $(this);
                    $('.card-path', $this).attr('name', inputName + '[' + $this.index() + '][path]');
                    $('.card-alt', $this).attr('name', inputName + '[' + $this.index() + '][alt]');
                });
            },
        }).disableSelection();

        let selectLimit = parseInt('{{ $limit }}');
        let elf_{{ str_replace('-', '_', $id) }} = $('#{{ $id }}-elfinder').elfinder({
            lang: '{{ $lang }}',
            customData: {
                _token: '{{ csrf_token() }}'
            },
            url: '{{ langRoute('administrator.elfinder.connector') }}',
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
                    ['back', 'forward', 'up'], ['view', 'sort'], ['copy', 'cut', 'paste'], ['rm'],
                    ['duplicate', 'rename'], ['mkdir', 'upload'], ['getfile', 'open', 'download'], ['info']
                ]
            },
            contextmenu: {
                cwd: ['reload', '|', 'upload', 'mkdir', 'paste', '|', 'view', 'sort', 'selectall', '|', 'info'],
                files: ['getfile', 'open', 'download', '|', 'copy', 'cut', 'paste', 'rm', '|', 'rename', '|', 'info']
            },
            getFileCallback: function (file) {
                $('#{{ $id }}').attr('disabled', true);

                if(selectLimit !== 0 && $('#{{ $id }}-list .card').length >= selectLimit) {
                    $('#{{ $id }}-modal').modal('hide');
                    swal({
                        title: "@lang('administrator.form.elfinder.limit_title')",
                        text: "@lang('administrator.form.elfinder.limit_text', ['limit' => $limit])",
                        confirmButtonText: "@lang('administrator.form.elfinder.limit_confirm_button')",
                        confirmButtonClass: "btn-danger",
                        closeOnConfirm: true
                    });
                } else {
                    $('#{{ $id }}-list').append($('#{{ $id }}-template').html().replace(/#replace_path/g, '/' + file.path.replace(/\\/g, '/')));
                }

                $('#{{ $id }}-list .card').each(function() {
                    let inputName = '{{ $name }}';
                    let $this = $(this);
                    $('.card-path', $this).attr('name', inputName + '[' + $this.index() + '][path]');
                    $('.card-alt', $this).attr('name', inputName + '[' + $this.index() + '][alt]');
                });
            }
        }).elfinder('instance');

        {{-- 刪除圖片 --}}
        $('body').delegate('#{{ $id }}-list .delBtn', 'click', function(){
            let $this = $(this);
            swal({
                title: "@lang('administrator.form.elfinder.remove_title')",
                text: "@lang('administrator.form.elfinder.remove_text')",
                type: "info",
                showCancelButton: true,
                cancelButtonText: "@lang('administrator.form.elfinder.remove_cancel_button')",
                confirmButtonText: "@lang('administrator.form.elfinder.remove_confirm_button')",
                confirmButtonClass: "btn-danger",
                closeOnConfirm: false
            }, function(){
                $this.parents('.card').remove();

                $('#{{ $id }}-list .card').each(function() {
                    let inputName = '{{ $name }}';
                    let $this = $(this);
                    $('.card-path', $this).attr('name', inputName + '[' + $this.index() + '][path]');
                    $('.card-alt', $this).attr('name', inputName + '[' + $this.index() + '][alt]');
                });

                if ($('#{{ $id }}-list .card').length < 1) {
                    $('#{{ $id }}').removeAttr('disabled');
                }

                swal("@lang('administrator.form.elfinder.remove_success_title')", "@lang('administrator.form.elfinder.remove_success_text')", "success");
            });
        });
    });
})(jQuery);
</script>
@endpush