<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $value
 *
 * Options
 * @var boolean $plaintText
 */
?>
<div class="form-group row {{ $language ? 'len' : '' }}">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-10">
        @if($plaintText)
        <input type="text" class="form-control-plaintext" id="{{ $id }}" value="{{ $value }}" readonly />
        @else
        <div class="form-text" id="{{ $id }}">{{ $value }}</div>
        @endif
    </div>
</div>