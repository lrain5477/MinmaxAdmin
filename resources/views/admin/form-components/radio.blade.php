<?php
/**
 * @var string $id
 * @var string $label
 * @var string $name
 * @var string $value
 * @var array $listData
 *
 * Options
 * @var bool $required
 * @var bool $inline
 * @var string $color
 * @var string $hint
 */
?>
<div class="form-group row">
    <label class="col-sm-2 col-form-label">{{ $label }}{!! $required === true ? '<span class="text-danger ml-1">*</span>' : '' !!}</label>
    <div class="col-sm-10">
    @if(array_key_exists($value, $listData))
        @foreach($listData as $listKey => $listItem)
        <div class="custom-control custom-radio {{ $inline === true ? 'custom-control-inline' : '' }} {{ $color }}">
            <input class="custom-control-input" type="radio"
                   id="{{ $id }}-{{ $listKey }}"
                   name="{{ $name }}"
                   value="{{ $listKey }}"
                   {{ $listKey == $value ? 'checked' : '' }}
                   {{ $required === true && $loop->first ? 'required' : '' }} />
            <label class="custom-control-label" for="{{ $id }}-{{ $listKey }}">{{ $listItem['title'] ?? '' }}</label>
        </div>
        @endforeach
    @else
        @foreach($listData as $listKey => $listItem)
        <div class="custom-control custom-radio {{ $inline === true ? 'custom-control-inline' : '' }} {{ $color }}">
            <input class="custom-control-input" type="radio"
                   id="{{ $id }}-{{ $listKey }}"
                   name="{{ $name }}"
                   value="{{ $listKey }}"
                   {{ $loop->first ? 'checked' : '' }}
                   {{ $required === true && $loop->first ? 'required' : '' }} />
            <label class="custom-control-label" for="{{ $id }}-{{ $listKey }}">{{ $listItem['title'] ?? '' }}</label>
        </div>
        @endforeach
    @endif
    </div>
    @if($hint !== '')
    <small class="form-text text-muted ml-sm-auto col-sm-10">{!! $hint !!}</small>
    @endif
</div>