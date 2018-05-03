<?php
/**
 * @var string $id
 * @var string $column
 * @var integer $value it's 0 or 1
 * @var string $uri
 * @var string $model
 */
?>
<div class="text-center">
    <a class="badge badge-pill {{ $value == 1 ? 'badge-danger' : 'badge-secondary' }} badge-switch" href="#1"
       title="@lang('admin.grid.click_to_switch')"
       data-url="{{ route('admin.switch', ['uri' => $uri]) }}"
       data-column="{{ $column }}"
       data-value="{{ $value }}"
       data-id="{{ $id }}">
        @lang("models.{$model}.selection.{$column}.{$value}")
    </a>
</div>