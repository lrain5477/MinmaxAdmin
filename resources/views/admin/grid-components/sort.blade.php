<?php
/**
 * @var string $id
 * @var string $column
 * @var string $value
 * @var string $uri
 * @var string $model
 */
?>
<div class="text-nowrap talbe-sort text-center">
    <span class="text-hide" id="vSortIndex{{ $id }}">{{ $value }}</span><!--
    --><a class="btn btn-link icon-arrow-long-up p-0 m-0 updateSort" role="button" aria-pressed="true" data-act="up" data-guid="{{ $id }}" data-column="{{ $column }}"></a>
    <input class="form-control form-control-sm text-center d-inline-block sortIndex"
           id="{{ $column }}_{{ $id }}"
           name="{{ $column }}[{{ $id }}]"
           type="text"
           value="{{ $value }}"
           data-url="{{ route('admin.sort', ['uri' => $uri]) }}"
           data-guid="{{ $id }}"
           data-column="{{ $column }}"
           onchange="updateSort('{{ $column }}', '{{ $id }}')"
           style="margin-right: 0;">
    <a class="btn btn-link icon-arrow-long-down p-0 m-0 updateSort" role="button" aria-pressed="true" data-act="down" data-guid="{{ $id }}" data-column="{{ $column }}"></a>
</div>