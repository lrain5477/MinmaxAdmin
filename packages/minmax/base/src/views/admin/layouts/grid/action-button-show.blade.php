<?php
/**
 * @var string $uri
 * @var string $id
 */
?>
<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::admin.grid.actions.view')" href="{{ langRoute("admin.{$uri}.show", [$id]) }}">
    <i class="icon-eye3"></i><span class="text-hide">@lang('MinmaxBase::admin.grid.actions.view')</span>
</a>