<?php
/**
 * @var string $name
 * @var string $emptyLabel
 * @var array $parameters
 * @var string $current
 */
?>
<div class="col col-md-auto ml-1">
    <select class="bs-select form-control min-w-select sch_select" id="searchActive" data-style="btn-outline-light btn-sm">
        <option value="" {{ $current === '' ? 'selected' : '' }}>{{ $emptyLabel }}</option>
        @foreach($parameters as $value => $parameter)
        <option value="{{ $value }}" {{ $current === $value ? 'selected' : '' }}>{{ array_get($parameter, 'title') }}</option>
        @endforeach
    </select>
</div>