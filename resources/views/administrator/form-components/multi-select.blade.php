<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var array $values
 * @var bool $required
 * @var array $listData
 *
 * Options
 * @var bool $group
 * @var integer $size
 * @var string $title
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-{{ $size }}">
        <select class="multiSelect" id="{{ $id }}" name="{{ $name }}" multiple {{ $required === true ? 'required' : '' }}>
        @if($group)
            @foreach($listData as $groupLabel => $listSet)
            <optgroup label="{{ $groupLabel }}">
                @foreach($listSet as $listKey => $listLabel)
                <option value="{{ $listKey }}" {{ in_array($listKey, $values) ? 'selected' : '' }}>{{ $listLabel }}</option>
                @endforeach
            </optgroup>
            @endforeach
        @else
            @foreach($listData as $listKey => $listLabel)
            <option value="{{ $listKey }}" {{ in_array($listKey, $values) ? 'selected' : '' }}>{{ $listLabel }}</option>
            @endforeach
        @endif
        </select>
        <div class="button-multiselect-box mt-1">
            <a class="select-all btn btn-secondary btn-sm" href="#">@lang('administrator.form.select_all')</a>
            <a class="deselect-all btn btn-secondary btn-sm" href="#">@lang('administrator.form.select_clear')</a>
        </div>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>