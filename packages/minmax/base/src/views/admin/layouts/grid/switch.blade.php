<?php
/**
 * @var string $id
 * @var string $column
 * @var integer $value it's 0 or 1
 * @var string $uri
 * @var array $parameter
 */
?>
<div class="text-center">
    <a class="badge badge-pill badge-{{ array_get($parameter, 'options.class', 'secondary') }} badge-switch" href="#"
       title="@lang('MinmaxBase::admin.grid.click_to_switch')"
       data-url="{{ langRoute("admin.{$uri}.ajaxSwitch") }}"
       data-column="{{ $column }}"
       data-value="{{ $value }}"
       data-id="{{ $id }}">
       {{ array_get($parameter, 'title', $value) }}
    </a>
</div>