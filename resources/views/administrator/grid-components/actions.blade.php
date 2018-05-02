<?php
/**
 * @var string $uri
 * @var string $id
 * @var array $rules
 */
?><!--
-->@if(in_array('R', $rules))<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('administrator.grid.actions.view')" href="{{ route('administrator.show', ['uri' => $uri, 'id' => $id]) }}">
    <i class="icon-eye3"></i><span class="text-hide">@lang('administrator.grid.actions.view')</span>
</a>@endif<!--
-->@if(in_array('U', $rules))<a class="btn btn-outline-default btn-sm" role="button" aria-pressed="true" title="@lang('administrator.grid.actions.edit')" href="{{ route('administrator.edit', ['uri' => $uri, 'id' => $id]) }}">
    <i class="icon-pencil"></i><span class="text-hide">@lang('administrator.grid.actions.edit')</span>
</a>@endif<!--
-->@if(in_array('D', $rules))<form action="{{ route('administrator.destroy', ['uri' => $uri, 'id' => $id]) }}" method="POST" style="display: inline-block;">
    @method('DELETE')
    @csrf
    <button class="btn btn-outline-default btn-sm delItem" title="@lang('administrator.grid.actions.delete')" type="submit" role="button" aria-pressed="true">
        <i class="icon-trash"></i><span class="text-hide">@lang('administrator.grid.actions.delete')</span>
    </button>
</form>@endif