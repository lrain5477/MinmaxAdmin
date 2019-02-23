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
 * @var integer $size
 * @var integer $limit
 * @var boolean $search
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
        <select multiple class="bs-select form-control"
                id="{{ $id }}"
                name="{{ $name }}"
                data-size="6"
                data-max-options="{{ $limit < 1 ? 'false' : $limit }}"
                data-live-search="{{ $search ? 'true' : 'false' }}"
                {!! $required === true ? '' : ('title="' . ($title === '' ? __('MinmaxBase::admin.form.select_default_title') : $title) . '"') !!}
                {{ $required === true ? 'required' : '' }}>
        @if($group)
            @foreach($listData as $groupLabel => $listSet)
            <optgroup label="{{ $groupLabel }}">
                @foreach($listSet as $listKey => $listItem)
                <option value="{{ $listKey }}"
                        title="{{ array_get($listItem, 'options.text') }}"
                        {{ in_array($listKey, old(str_replace(['[', ']'], ['.', ''], $name), $values)) ? 'selected' : '' }}>{{ array_get($listItem, 'title') }}</option>
                @endforeach
            </optgroup>
            @endforeach
        @else
            @foreach($listData as $listKey => $listItem)
            <option value="{{ $listKey }}"
                    title="{{ array_get($listItem, 'options.text') }}"
                    {{ in_array($listKey, old(str_replace(['[', ']'], ['.', ''], $name), $values)) ? 'selected' : '' }}>{{ array_get($listItem, 'title') }}</option>
            @endforeach
        @endif
        </select>
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>