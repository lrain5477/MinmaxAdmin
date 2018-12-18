<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 * @var array $value
 * @var array $listData
 *
 * Options
 * @var boolean $required
 * @var boolean $inline
 * @var string $color
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">
        @if($language)<i class="icon-globe"></i>@endif
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
                   {{ in_array($listKey, $value) ? 'checked' : '' }}
                   {{ $required === true && $loop->first ? 'required' : '' }} />
            <label class="custom-control-label" for="{{ $id }}-{{ $listKey }}">{{ $listItem['title'] ?? '' }}</label>
        </div>
        @endforeach
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>