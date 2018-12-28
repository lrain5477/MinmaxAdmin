<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links')
    @if(request('group'))
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.system-parameter-group.index") }}" title="@lang('MinmaxBase::administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.back_list')</span>
    </a>
    @endif
    <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.create", ['group' => request('group')]) }}" title="@lang('MinmaxBase::administrator.form.create')">
        <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.create')</span>
    </a>
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Base\Administrator\SystemParameterItemPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="label">@lang('MinmaxBase::models.SystemParameterItem.label')</option>
    <option value="value">@lang('MinmaxBase::models.SystemParameterItem.value')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('group_id', 'searchGroup', ['emptyLabel' => __('MinmaxBase::models.SystemParameterItem.group_id'), 'current' => intval(request('group'))]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.SystemParameterItem.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-20">@lang('MinmaxBase::models.SystemParameterItem.group_id')</th>
        <th class="w-20">@lang('MinmaxBase::models.SystemParameterItem.label')</th>
        <th class="w-15">@lang('MinmaxBase::models.SystemParameterItem.value')</th>
        <th>@lang('MinmaxBase::models.SystemParameterItem.sort')</th>
        <th>@lang('MinmaxBase::models.SystemParameterItem.active')</th>
        <th class="nosort">@lang('MinmaxBase::administrator.grid.title.action')</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection

@push('scripts')
<script>
(function($) {
    $(function() {
        $('#tableList').DataTable({
            language: {
                url: '{{ asset("static/admin/js/lang/" . app()->getLocale() . "/datatables.json") }}'
            },
            ajax: {
                url: '{{ langRoute("administrator.{$pageData->uri}.ajaxDataTable") }}',
                data: function (d) {
                    var searchKeyword = $('#sch_keyword').val();
                    var searchColumn = $('#sch_column').val();

                    d.filter = {
                        "label": searchKeyword,
                        "value": searchKeyword
                    };

                    if (searchColumn !== '') {
                        for (var column in d.filter) {
                            if (column !== searchColumn && d.filter.hasOwnProperty(column)) {
                                d.filter[column] = '';
                            }
                        }
                    }

                    d.equal = {
                        "group_id": $('#searchGroup').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'group_id', name: 'group_id'},
                {data: 'label', name: 'label'},
                {data: 'value', name: 'value'},
                {data: 'sort', name: 'sort'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [0, 'asc'], [3, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush