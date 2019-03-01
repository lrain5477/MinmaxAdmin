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
<div class="form-group row {{ $language ? 'len' : '' }}">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">
        {{ $label }}<!--
        @if($required)--><span class="text-danger ml-1">*</span><!--@endif
        -->
    </label>
    <div class="col-sm-{{ $size }}">
        <div class="input-group">
            <div class="input-group-prepend" onclick="$(this).parent().find('input').click();">
                <span class="input-group-text"><i class="icon-calendar"></i></span>
            </div>
            <input type="text" class="form-control datepicker-{{ $type }}"
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value="{{ old(str_replace(['[', ']'], ['.', ''], $name), $value) }}"
                   placeholder="{{ $placeholder }}"
                   {{ $required ? 'required' : '' }} />
        </div>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>