<?php
/**
 * @var string $id
 * @var string $label
 * @var array $images
 * @var boolean $altShow
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-10">
        <div class="file-img-list" id="{{ $id }}">
            @foreach($images as $image)
            <div class="card mr-2 d-inline-block ui-sortable-handle">
                <a class="thumb" href="{{ asset($image['path']) }}" data-fancybox="">
                    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"><img src="{{ asset($image['path']) }}"/></span>
                </a>
                @if($altShow)
                <div class="form-row mt-1">
                    <div class="col">
                        <input class="form-control form-control-sm mb-1" type="text" value="{{ $image['alt'] }}" placeholder="ALT Text" readonly />
                    </div>
                </div>
                @endif
            </div>
            @endforeach
            @if(count($images) < 1)
            <div class="card mr-2 d-inline-block ui-sortable-handle">
                <div class="thumb">
                    <span class="imgFill imgLiquid_bgSize imgLiquid_ready"><img src="{{ asset('admin/images/noimage.gif') }}"/></span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>