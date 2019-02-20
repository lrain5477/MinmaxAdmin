<?php
/**
 * @var string $id
 * @var boolean $language
 * @var string $label
 * @var string $value
 */
?>
<div class="form-group row {{ $language ? 'len' : '' }}">
    <label class="col-sm-2 col-form-label" for="{{ $id }}">{{ $label }}</label>
    <div class="col-sm-10">
        <div class="form-text" id="{{ $id }}">{!! $value !!}</div>
    </div>
</div>