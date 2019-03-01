<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var string $values
 * @var array $listData
 *
 * Options
 * @var integer $size
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}<span class="text-danger ml-1">*</span></label>
    <div class="col-sm-{{ $size }}">
        <select class="bs-select form-control"
                id="{{ $id }}"
                name="{{ $name }}"
                title="@lang('MinmaxProduct::administrator.form.ProductSet.please_select')"
                data-size="6"
                data-live-search="true"
                data-actions-box="true"
                data-select-all-text="@lang('MinmaxBase::administrator.form.select_all')"
                data-deselect-all-text="@lang('MinmaxBase::administrator.form.select_clear')"
                multiple
                required>
            @foreach($listData as $listKey => $listItem)
            <option value="{{ $listKey }}" title="{{ array_get($listItem, 'options.text', '') }}" {{ in_array($listKey, old(str_replace(['[', ']'], ['.', ''], $name), $values)) ? 'selected' : '' }}>{{ $listItem['title'] ?? '' }}</option>
            @endforeach
        </select>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>
