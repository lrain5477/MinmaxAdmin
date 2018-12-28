<?php
/**
 * @var string $uri
 * @var string $id
 */
?>
<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::administrator.grid.actions.view')" href="{{ langRoute("administrator.{$uri}.show", [$id]) }}">
    <i class="icon-eye3"></i><span class="text-hide">@lang('MinmaxBase::administrator.grid.actions.view')</span>
</a>