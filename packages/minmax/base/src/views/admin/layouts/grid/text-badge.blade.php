<?php
/**
 * @var string|integer $value
 * @var array $parameter
 */
?>
<div class="text-center">
    <span class="badge badge-pill badge-{{ $parameter['class'] ?? 'secondary' }}">
        {{ $parameter['title'] ?? $value }}
    </span>
</div>