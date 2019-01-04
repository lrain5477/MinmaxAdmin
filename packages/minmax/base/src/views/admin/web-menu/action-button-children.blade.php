<?php
/**
 * @var string|integer $id
 * @var string $uri
 */
?>
<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::admin.grid.actions.children')" href="{{ langRoute("admin.{$uri}.index", ['parent' => $id]) }}">
    <i class="icon-plus2"></i><span class="text-hide">@lang('MinmaxBase::admin.grid.actions.children')</span>
</a>