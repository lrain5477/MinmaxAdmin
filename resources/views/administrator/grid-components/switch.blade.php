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
    <a class="badge badge-pill badge-{{ $parameter['class'] ?? 'secondary' }} badge-switch" href="#1"
       title="@lang('administrator.grid.click_to_switch')"
       data-url="{{ langRoute("administrator.{$uri}.ajaxSwitch") }}"
       data-column="{{ $column }}"
       data-value="{{ $value }}"
       data-id="{{ $id }}">
        {{ $parameter['title'] ?? __("models.{$model}.selection.{$column}.{$value}") }}
    </a>
</div>