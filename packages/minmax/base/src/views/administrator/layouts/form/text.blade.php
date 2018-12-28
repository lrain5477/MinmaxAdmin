<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 * @var string $value
 *
 * Options
 * @var boolean $required
 * @var integer $size
 * @var string $icon
 * @var string $placeholder
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">
        @if($language)<i class="icon-globe"></i>@endif
        {{ $label }}<!--
        @if($required)--><span class="text-danger ml-1">*</span><!--@endif
        -->
    </label>
    <div class="col-sm-{{ $size }}">
        @if($icon === '')
        <input type="text" class="form-control"
               id="{{ $id }}"
               name="{{ $name }}"
               value="{{ old(str_replace(['[', ']'], ['.', ''], $name), $value) }}"
               placeholder="{{ $placeholder }}"
               {{ $required === true ? 'required' : '' }} />
        @else
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="{{ $icon }}"></i></span>
            </div>
            <input type="text" class="form-control"
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value="{{ old(str_replace(['[', ']'], ['.', ''], $name), $value) }}"
                   placeholder="{{ $placeholder }}"
                   {{ $required === true ? 'required' : '' }} />
        </div>
        @endif
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>