<?php
/**
 * @var string $id
 * @var string $column
 * @var integer $value it's 0 or 1
 * @var string $uri
 * @var string $model
 * @var array $parameter
 */
?>
<div class="text-center">
    <a class="badge badge-pill badge-{{ $parameter ? $parameter['class'] : 'secondary' }} badge-switch" href="#1"
       title="@lang('admin.grid.click_to_switch')"
       data-url="{{ route('admin.switch', ['uri' => $uri]) }}"
       data-column="{{ $column }}"
       data-value="{{ $value }}"
       data-id="{{ $id }}">
        {{ $parameter ? $parameter['title'] : __("models.{$model}.selection.{$column}.{$value}") }}
    </a>
</div>