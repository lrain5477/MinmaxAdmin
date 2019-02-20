<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 *
 * Options
 * @var boolean $required
 * @var integer $size
 * @var string $icon
 * @var string $placeholder
 * @var string $hint
 */
?>
<div class="form-group row {{ $language ? 'len' : '' }}">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">
        {{ $label }}<!--
        @if($required)--><span class="text-danger ml-1">*</span><!--@endif
        -->
    </label>
    <div class="col-sm-{{ $size }}">
        @if($icon === '')
        <input type="password" class="form-control"
               id="{{ $id }}"
               name="{{ $name }}"
               value=""
               placeholder="{{ $placeholder }}"
               autocomplete="off"
               {{ $required === true ? 'required' : '' }} />
        @else
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="{{ $icon }}"></i></span>
            </div>
            <input type="password" class="form-control"
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value=""
                   placeholder="{{ $placeholder }}"
                   autocomplete="off"
                   {{ $required === true ? 'required' : '' }} />
        </div>
        @endif
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>