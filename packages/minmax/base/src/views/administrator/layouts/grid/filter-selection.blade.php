<?php
/**
 * @var string $name
 * @var string $emptyLabel
 * @var array $parameters
 * @var string $current
 * @var boolean $search
 */
?>
<div class="col col-md-auto ml-1">
    <select class="bs-select form-control min-w-select sch_select" id="{{ $name }}"
            data-style="btn-outline-light btn-sm"
            data-live-search="{{ $search ? 'true' : 'false' }}">
        <option value="" {{ $current === '' ? 'selected' : '' }}>{{ $emptyLabel }}</option>
        @foreach($parameters as $value => $parameter)
        <option value="{{ $value }}" {{ $current === $value ? 'selected' : '' }}>{{ array_get($parameter, 'title') }}</option>
        @endforeach
    </select>
</div>
