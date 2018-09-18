<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var array $value
 * @var array $images
 * @var array $additionalFields
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
        <button class="btn btn-secondary" type="button" data-target="#{{ $id }}-modal" data-toggle="modal"><i class="icon-pictures"> </i> @lang('admin.form.button.media_image')</button>
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
                <input type="hidden" name="{{ $name }}[{{ $loop->index }}][path]" value="{{ $image['path'] ?? '' }}" required />
                <a class="thumb" href="{{ asset($image['path']) }}" data-fancybox="">
                    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"><img src="{{ asset($image['path']) }}"/></span>
                </a>
                <div class="form-row mt-1">
                    <div class="col text-center">
                        <div class="btn-group btn-group-sm justify-content-center">
                            <button class="btn btn-outline-default delBtn" type="button"><i class="icon-trash2"></i></button>
                            @if(count($additionalFields) > 0)
                            <button class="btn btn-outline-default addi-button" type="button" title="設定" data-target="#{{ $id }}-modal-set-{{ $loop->index }}" data-toggle="modal"><i class="icon-wrench"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
                @if(count($additionalFields) > 0)
                <div class="modal fade bd-example-modal-md" id="{{ $id }}-modal-set-{{ $loop->index }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <ul class="nav nav-tabs" id="{{ $id }}-tabModal-{{ $loop->index }}" role="{{ $id }}-tabModal-{{ $loop->index }}">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           id="{{ $id }}-tabModal-{{ $loop->index }}-1"
                                           data-toggle="tab"
                                           href="#{{ $id }}-tabModal-pane-{{ $loop->index }}-1"
                                           role="tab"
                                           aria-controls="{{ $id }}-tabModal-pane-{{ $loop->index }}-1"
                                           aria-selected="true">圖片資訊</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-4" id="{{ $id }}-tabModalContent-{{ $loop->index }}">
                                    <div class="tab-pane fade show active" id="{{ $id }}-tabModal-pane-{{ $loop->index }}-1" role="tabpanel" aria-labelledby="{{ $id }}-tabModal-{{ $loop->index }}-1">
                                        <div class="row">
                                            <div class="col">
                                                <fieldset>
                                                    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-3"></i>基本設定</legend>
                                                    @foreach($additionalFields as $column => $type)
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">@lang('models.' . str_replace('-', '.', $id) . '.' . $column)</label>
                                                        <div class="col-sm-10">
                                                        @switch($type)
                                                            @case('text')
                                                            <input class="form-control addi-{{ $column }}" type="text" name="{{ $name }}[{{ $loop->parent->index }}][{{ $column }}]" value="{{ $image[$column] ?? '' }}" />
                                                            @break
                                                            @case('textarea')
                                                            <textarea class="form-control addi-{{ $column }}" type="text" name="{{ $name }}[{{ $loop->parent->index }}][{{ $column }}]">{{ $image[$column] ?? '' }}</textarea>
                                                            @break
                                                        @endswitch
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="button" data-dismiss="modal">完成</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- 圖片小卡樣板 START --}}
<template id="{{ $id }}-template">
    <div class="card mr-2 d-inline-block ui-sortable-handle">
        <input type="hidden" class="card-path" name="{{ $name }}[DumpIndex][path]" value="#replace_path" required />
        <a class="thumb" href="#replace_path" data-fancybox="">
            <span class="imgFill imgLiquid_bgSize imgLiquid_ready"
                  style="background: url('#replace_path') center center no-repeat; background-size: cover;">
                <img src="#replace_path" style="display: none;" />
            </span>
        </a>
        <div class="form-row mt-1">
            <div class="col text-center">
                <div class="btn-group btn-group-sm justify-content-center">
                    <button class="btn btn-outline-default delBtn" type="button"><i class="icon-trash2"></i></button>
                    @if(count($additionalFields) > 0)
                    <button class="btn btn-outline-default addi-button" type="button" title="設定" data-target="#{{ $id }}-modal-set-DumpIndex" data-toggle="modal"><i class="icon-wrench"></i></button>
                    @endif
                </div>
            </div>
        </div>
        @if(count($additionalFields) > 0)
        <div class="modal fade bd-example-modal-md" id="{{ $id }}-modal-set-DumpIndex" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="{{ $id }}-tabModal-DumpIndex" role="{{ $id }}-tabModal-DumpIndex">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   id="{{ $id }}-tabModal-DumpIndex-1"
                                   data-toggle="tab"
                                   href="#{{ $id }}-tabModal-pane-DumpIndex-1"
                                   role="tab"
                                   aria-controls="{{ $id }}-tabModal-pane-DumpIndex-1"
                                   aria-selected="true">圖片資訊</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="{{ $id }}-tabModalContent-DumpIndex">
                            <div class="tab-pane fade show active" id="{{ $id }}-tabModal-pane-DumpIndex-1" role="tabpanel" aria-labelledby="{{ $id }}-tabModal-DumpIndex-1">
                                <div class="row">
                                    <div class="col">
                                        <fieldset>
                                            <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-3"></i>基本設定</legend>
                                            @foreach($additionalFields as $column => $type)
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">@lang('models.' . str_replace('-', '.', $id) . '.' . $column)</label>
                                                <div class="col-sm-10">
                                                @switch($type)
                                                    @case('text')
                                                    <input class="form-control addi-{{ $column }}" type="text" name="{{ $name }}[DumpIndex][{{ $column }}]" value="{{ $image[$column] ?? '' }}" />
                                                    @break
                                                    @case('textarea')
                                                    <textarea class="form-control addi-{{ $column }}" type="text" name="{{ $name }}[DumpIndex][{{ $column }}]">{{ $image[$column] ?? '' }}</textarea>
                                                    @break
                                                @endswitch
                                                </div>
                                            </div>
                                            @endforeach
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" data-dismiss="modal">完成</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</template>
{{-- 圖片小卡樣板 END --}}

@push('scripts')
{{-- 彈跳視窗 START --}}
<div class="modal fade bd-example-modal-lg" id="{{ $id }}-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('admin.form.button.media_image')</h5>
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
                    let thisId = '{{ $id }}';
                    let $this = $(this);
                    $('.card-path', $this).attr('name', inputName + '[' + $this.index() + '][path]');

                    @if(count($additionalFields) > 0)
                    $('.addi-button', $this).attr('href', '#' + thisId + '-modal-set-' + $this.index());
                    $('.modal', $this).attr('id', thisId + '-modal-set-' + $this.index());
                    $('.nav-tabs', $this)
                        .attr('id', thisId + '-tabModal-' + $this.index())
                        .attr('role', thisId + '-tabModal-' + $this.index());
                    $('.nav-link', $this)
                        .attr('id', thisId + '-tabModal-' + $this.index() + '-1')
                        .attr('href', '#' + thisId + '-tabModal-pane-' + $this.index() + '-1')
                        .attr('aria-controls', thisId + '-tabModal-pane-' + $this.index() + '-1');
                    $('.tab-content', $this).attr('id', thisId + '-tabModalContent-' + $this.index());
                    $('.tab-pane', $this)
                        .attr('id', thisId + '-tabModal-pane-' + $this.index() + '-1')
                        .attr('aria-labelledby', thisId + '-tabModal-' + $this.index() + '-1');
                    @foreach($additionalFields as $column => $type)
                    $('.addi-{{ $column }}', $this).attr('name', inputName + '[' + $this.index() + '][{{ $column }}]');
                    @endforeach
                    @endif
                });
            },
        }).disableSelection();

        let selectLimit = parseInt('{{ $limit }}');
        let elf_{{ str_replace('-', '_', $id) }} = $('#{{ $id }}-elfinder').elfinder({
            lang: '{{ $lang }}',
            customData: {
                _token: '{{ csrf_token() }}'
            },
            url: '{{ langRoute('admin.elfinder.connector') }}',
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
            },
            getFileCallback: function (file) {
                $('#{{ $id }}').attr('disabled', true);

                if(selectLimit !== 0 && $('#{{ $id }}-list .card').length >= selectLimit) {
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

                $('#{{ $id }}-list .card').each(function() {
                    let inputName = '{{ $name }}';
                    let thisId = '{{ $id }}';
                    let $this = $(this);
                    $('.card-path', $this).attr('name', inputName + '[' + $this.index() + '][path]');

                    @if(count($additionalFields) > 0)
                    $('.addi-button', $this).attr('href', '#' + thisId + '-modal-set-' + $this.index());
                    $('.modal', $this).attr('id', thisId + '-modal-set-' + $this.index());
                    $('.nav-tabs', $this)
                        .attr('id', thisId + '-tabModal-' + $this.index())
                        .attr('role', thisId + '-tabModal-' + $this.index());
                    $('.nav-link', $this)
                        .attr('id', thisId + '-tabModal-' + $this.index() + '-1')
                        .attr('href', '#' + thisId + '-tabModal-pane-' + $this.index() + '-1')
                        .attr('aria-controls', thisId + '-tabModal-pane-' + $this.index() + '-1');
                    $('.tab-content', $this).attr('id', thisId + '-tabModalContent-' + $this.index());
                    $('.tab-pane', $this)
                        .attr('id', thisId + '-tabModal-pane-' + $this.index() + '-1')
                        .attr('aria-labelledby', thisId + '-tabModal-' + $this.index() + '-1');
                    @foreach($additionalFields as $column => $type)
                    $('.addi-{{ $column }}', $this).attr('name', inputName + '[' + $this.index() + '][{{ $column }}]');
                    @endforeach
                    @endif
                });
            }
        }).elfinder('instance');

        {{-- 刪除圖片 --}}
        $('body').delegate('#{{ $id }}-list .delBtn', 'click', function(){
            let $this = $(this);
            swal({
                title: "@lang('admin.form.elfinder.remove_title')",
                text: "@lang('admin.form.elfinder.remove_text')",
                type: "info",
                showCancelButton: true,
                cancelButtonText: "@lang('admin.form.elfinder.remove_cancel_button')",
                confirmButtonText: "@lang('admin.form.elfinder.remove_confirm_button')",
                confirmButtonClass: "btn-danger",
                closeOnConfirm: false
            }, function(){
                $this.parents('.card').remove();

                $('#{{ $id }}-list .card').each(function() {
                    let inputName = '{{ $name }}';
                    let thisId = '{{ $id }}';
                    let $this = $(this);
                    $('.card-path', $this).attr('name', inputName + '[' + $this.index() + '][path]');

                    @if(count($additionalFields) > 0)
                    $('.addi-button', $this).attr('href', '#' + thisId + '-modal-set-' + $this.index());
                    $('.modal', $this).attr('id', thisId + '-modal-set-' + $this.index());
                    $('.nav-tabs', $this)
                        .attr('id', thisId + '-tabModal-' + $this.index())
                        .attr('role', thisId + '-tabModal-' + $this.index());
                    $('.nav-link', $this)
                        .attr('id', thisId + '-tabModal-' + $this.index() + '-1')
                        .attr('href', '#' + thisId + '-tabModal-pane-' + $this.index() + '-1')
                        .attr('aria-controls', thisId + '-tabModal-pane-' + $this.index() + '-1');
                    $('.tab-content', $this).attr('id', thisId + '-tabModalContent-' + $this.index());
                    $('.tab-pane', $this)
                        .attr('id', thisId + '-tabModal-pane-' + $this.index() + '-1')
                        .attr('aria-labelledby', thisId + '-tabModal-' + $this.index() + '-1');
                    @foreach($additionalFields as $column => $type)
                    $('.addi-{{ $column }}', $this).attr('name', inputName + '[' + $this.index() + '][{{ $column }}]');
                    @endforeach
                    @endif
                });

                if ($('#{{ $id }}-list .card').length < 1) {
                    $('#{{ $id }}').removeAttr('disabled');
                }

                swal("@lang('admin.form.elfinder.remove_success_title')", "@lang('admin.form.elfinder.remove_success_text')", "success");
            });
        });
    });
})(jQuery);
</script>
@endpush