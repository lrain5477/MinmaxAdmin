<?php
/**
 * @var string|integer $value
 * @var string $column
 * @var string $model
 * @var array $parameter
 */
?>
<div class="text-center">
    <span class="badge badge-pill badge-{{ $parameter['class'] ?? 'secondary' }}">
        {{ $parameter['title'] ?? __("models.{$model}.selection.{$column}.{$value}") }}
    </span>
</div>