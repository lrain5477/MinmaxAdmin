<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('siteParameterGroupCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Base\Admin\SiteParameterItemPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="label">@lang('MinmaxBase::models.SiteParameterItem.label')</option>
    <option value="value">@lang('MinmaxBase::models.SiteParameterItem.value')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('group_id', 'searchGroup', ['emptyLabel' => __('MinmaxBase::models.SiteParameterItem.group_id')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.SiteParameterItem.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('MinmaxBase::models.SiteParameterItem.group_id')</th>
        <th class="nosort">@lang('MinmaxBase::models.SiteParameterItem.label')</th>
        <th>@lang('MinmaxBase::models.SiteParameterItem.value')</th>
        <th>@lang('MinmaxBase::models.SiteParameterItem.sort')</th>
        <th>@lang('MinmaxBase::models.SiteParameterItem.active')</th>
        <th class="nosort">@lang('MinmaxBase::admin.grid.title.action')</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection

@push('scripts')
<script>
$(function() {
    $('#tableList').DataTable({
        language: {
            url: '{{ asset("static/admin/js/lang/" . app()->getLocale() . "/datatables.json") }}'
        },
        ajax: {
            url: '{{ langRoute("admin.{$pageData->uri}.ajaxDataTable") }}',
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
</script>
@endpush