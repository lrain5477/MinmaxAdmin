<?php
/**
 * @var string|integer $value
 * @var array $parameter
 */
?>
<div class="text-center">
    <span class="badge badge-pill badge-{{ array_get($parameter, 'options.class', 'secondary') }}">
        {{ array_get($parameter, 'title', $value) }}
    </span>
</div>