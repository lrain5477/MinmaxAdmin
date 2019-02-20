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
 * @var boolean $group
 * @var integer $size
 * @var string $title
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
        <select class="multiSelect" id="{{ $id }}" name="{{ $name }}" multiple {{ $required === true ? 'required' : '' }}>
        @if($group)
            @foreach($listData as $groupLabel => $listSet)
            <optgroup label="{{ $groupLabel }}">
                @foreach($listSet as $listKey => $listItem)
                <option value="{{ $listKey }}" {{ in_array($listKey, old(str_replace(['[', ']'], ['.', ''], $name), $values)) ? 'selected' : '' }}>{{ $listItem['title'] ?? '' }}</option>
                @endforeach
            </optgroup>
            @endforeach
        @else
            @foreach($listData as $listKey => $listItem)
            <option value="{{ $listKey }}" {{ in_array($listKey, old(str_replace(['[', ']'], ['.', ''], $name), $values)) ? 'selected' : '' }}>{{ $listItem['title'] ?? '' }}</option>
            @endforeach
        @endif
        </select>
        <div class="button-multiselect-box mt-1">
            <a class="select-all btn btn-secondary btn-sm" href="#">@lang('MinmaxBase::admin.form.select_all')</a>
            <a class="deselect-all btn btn-secondary btn-sm" href="#">@lang('MinmaxBase::admin.form.select_clear')</a>
        </div>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>