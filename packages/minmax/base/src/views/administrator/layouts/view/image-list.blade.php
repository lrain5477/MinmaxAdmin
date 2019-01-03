<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var array $images
 * @var array $additionalFields
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">
        @if($language)<i class="icon-globe"></i>@endif
        {{ $label }}
    </label>
    <div class="col-sm-10">
        <div class="file-img-list" id="{{ $id }}">
            @foreach($images as $image)
            <div class="card mr-2 d-inline-block ui-sortable-handle">
                <a class="thumb" href="{{ asset($image['path']) }}" data-fancybox="">
                    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"><img src="{{ asset($image['path']) }}" alt="" /></span>
                </a>
                <div class="form-row mt-1">
                    <div class="col text-center">
                        <div class="btn-group btn-group-sm justify-content-center">
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
                                                        <label class="col-sm-2 col-form-label">@lang('models.' . str_replace('-', '.additional.', $id) . '.' . $column)</label>
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
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
            @if(count($images) < 1)
            <div class="card mr-2 d-inline-block ui-sortable-handle">
                <div class="thumb">
                    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"><img src="{{ asset('static/admin/images/common/noimage.gif') }}" alt="" /></span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>