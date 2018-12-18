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
 * @var string $type
 * @var integer $size
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
    <div class="col-xl-{{ $size }}">
            <input type="text" class="form-control datepicker-{{ $type }}" style="padding-left: 32px;"
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value="{{ old(str_replace(['[', ']'], ['.', ''], $name), $value) }}"
                   placeholder="{{ $placeholder }}"
                   {{ $required === true ? 'required' : '' }} />
            <i class="icon-calendar" style="position: absolute; bottom: 10px; left: 24px; top: auto; cursor: pointer; pointer-events: visible" onclick="$(this).parent().find('input').click();"></i>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>