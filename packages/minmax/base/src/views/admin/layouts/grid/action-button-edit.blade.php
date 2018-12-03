<?php
/**
 * @var string $uri
 * @var string $id
 */
?>
<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::admin.grid.actions.edit')" href="{{ langRoute("admin.{$uri}.edit", [$id]) }}">
    <i class="icon-pencil"></i><span class="text-hide">@lang('MinmaxBase::admin.grid.actions.edit')</span>
</a>