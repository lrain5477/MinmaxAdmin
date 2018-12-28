<?php
/**
 * @var string|integer $id
 * @var string $uri
 */
?>
<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::administrator.grid.actions.children')" href="{{ langRoute("administrator.{$uri}.index", ['group' => $id]) }}">
    <i class="icon-plus2"></i><span class="text-hide">@lang('MinmaxBase::administrator.grid.actions.children')</span>
</a>