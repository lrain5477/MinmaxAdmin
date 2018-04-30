<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var array $value
 * @var bool $required
 * @var array $listData
 *
 * Options
 * @var bool $inline
 * @var string $color
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-10">
        @foreach($listData as $listKey => $listLabel)
        <div class="custom-control custom-checkbox {{ $inline === true ? 'custom-control-inline' : '' }} {{ $color }}">
            <input class="custom-control-input" type="checkbox"
                   id="{{ $id }}-{{ $listKey }}"
                   name="{{ $name }}"
                   value="{{ $listKey }}"
                   {{ in_array($listKey, $value) ? 'checked' : '' }}
                   {{ $required === true && $loop->first ? 'required' : '' }} />
            <label class="custom-control-label" for="{{ $id }}-{{ $listKey }}">{{ $listLabel }}</label>
        </div>
        @endforeach
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>