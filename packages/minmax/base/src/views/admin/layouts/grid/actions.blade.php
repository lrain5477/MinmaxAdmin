<?php
/**
 * @var string $uri
 * @var string $id
 * @var array $rules
 */
?><!--
-->@if(in_array('R', $rules))<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::admin.grid.actions.view')" href="{{ langRoute("admin.{$uri}.show", [$id]) }}">
    <i class="icon-eye3"></i><span class="text-hide">@lang('MinmaxBase::admin.grid.actions.view')</span>
</a>@endif<!--
-->@if(in_array('U', $rules))<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('MinmaxBase::admin.grid.actions.edit')" href="{{ langRoute("admin.{$uri}.edit", [$id]) }}">
    <i class="icon-pencil"></i><span class="text-hide">@lang('MinmaxBase::admin.grid.actions.edit')</span>
</a>@endif<!--
-->@if(in_array('D', $rules))<form action="{{ langRoute("admin.{$uri}.destroy", [$id]) }}" method="POST" style="display: inline-block;">
    @method('DELETE')
    @csrf
    <button class="btn btn-outline-default btn-sm delItem" title="@lang('MinmaxBase::admin.grid.actions.delete')" type="submit" role="button" aria-pressed="true">
        <i class="icon-trash"></i><span class="text-hide">@lang('MinmaxBase::admin.grid.actions.delete')</span>
    </button>
</form>@endif