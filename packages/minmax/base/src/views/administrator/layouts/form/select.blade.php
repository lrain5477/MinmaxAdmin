<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $name
 * @var string $value
 * @var array $listData
 *
 * Options
 * @var boolean $required
 * @var integer $size
 * @var boolean $search
 * @var string $title
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
        <select class="bs-select form-control"
                id="{{ $id }}"
                data-size="6"
                name="{{ $name }}"
                data-live-search="{{ $search ? 'true' : 'false' }}"
                {!! $required === true ? '' : ('title="' . ($title === '' ? __('MinmaxBase::administrator.form.select_default_title') : $title) . '"') !!}
                {{ $required === true ? 'required' : '' }}>
        @if(array_key_exists($value, $listData))
            @foreach($listData as $listKey => $listItem)
            <option value="{{ $listKey }}" {{ $listKey == old(str_replace(['[', ']'], ['.', ''], $name), $value) ? 'selected' : '' }}>{{ $listItem['title'] ?? '' }}</option>
            @endforeach
        @else
            @foreach($listData as $listKey => $listItem)
            <option value="{{ $listKey }}" {{ $required === true && $loop->first ? 'selected' : '' }}>{{ $listItem['title'] ?? '' }}</option>
            @endforeach
        @endif
        </select>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>