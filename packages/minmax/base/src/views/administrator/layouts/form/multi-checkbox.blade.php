<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 * @var array $values
 * @var array $listData
 *
 * Options
 * @var boolean $required
 * @var boolean $inline
 * @var string $color
 * @var string $hint
 */
?>
<div class="form-group row {{ $language ? 'len' : '' }}">
    <label class="col-sm-2 col-form-label">
        {{ $label }}<!--
        @if($required)--><span class="text-danger ml-1">*</span><!--@endif
        -->
    </label>
    <div class="col-sm-10">
        @foreach($listData as $listKey => $listItem)
        <div class="custom-control custom-checkbox {{ $inline === true ? 'custom-control-inline' : '' }} {{ $color }}">
            <input class="custom-control-input" type="checkbox"
                   id="{{ $id }}-{{ $listKey }}"
                   name="{{ $name }}"
                   value="{{ $listKey }}"
                   {{ in_array($listKey, $values) ? 'checked' : '' }}
                   {{ $required && $loop->first ? 'required' : '' }} />
            <label class="custom-control-label" for="{{ $id }}-{{ $listKey }}">{{ array_get($listItem, 'title') }}</label>
        </div>
        @endforeach
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>