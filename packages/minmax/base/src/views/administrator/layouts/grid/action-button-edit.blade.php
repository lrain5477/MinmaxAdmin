<?php
/**
 * @var string $uri
 * @var string $id
 */
?>
<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::administrator.grid.actions.edit')" href="{{ langRoute("administrator.{$uri}.edit", [$id]) }}">
    <i class="icon-pencil"></i><span class="text-hide">@lang('MinmaxBase::administrator.grid.actions.edit')</span>
</a>