<?php
/**
 * @var string $uri
 * @var string $id
 */
?>
<form action="{{ langRoute("administrator.{$uri}.destroy", [$id]) }}" method="POST" style="display: inline-block;">
    @method('DELETE')
    @csrf
    <button class="btn btn-outline-default btn-sm delItem" title="@lang('MinmaxBase::administrator.grid.actions.delete')" type="submit" role="button" aria-pressed="true">
        <i class="icon-trash"></i><span class="text-hide">@lang('MinmaxBase::administrator.grid.actions.delete')</span>
    </button>
</form>