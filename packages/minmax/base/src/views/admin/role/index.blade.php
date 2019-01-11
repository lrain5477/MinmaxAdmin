<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('roleCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Base\Admin\RolePresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="name">@lang('MinmaxBase::models.Role.name')</option>
    <option value="display_name">@lang('MinmaxBase::models.Role.display_name')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('guard', 'searchGuard', ['emptyLabel' => __('MinmaxBase::models.Role.guard')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.Role.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-15">@lang('MinmaxBase::models.Role.guard')</th>
        <th class="w-20">@lang('MinmaxBase::models.Role.name')</th>
        <th class="w-25 nosort">@lang('MinmaxBase::models.Role.display_name')</th>
        <th>@lang('MinmaxBase::models.Role.active')</th>
        <th class="nosort">@lang('MinmaxBase::admin.grid.title.action')</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
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
                    "name": searchKeyword,
                    "display_name": searchKeyword
                };

                if (searchColumn !== '') {
                    for (var column in d.filter) {
                        if (column !== searchColumn && d.filter.hasOwnProperty(column)) {
                            d.filter[column] = '';
                        }
                    }
                }

                d.equal = {
                    "guard": $('#searchGuard').val(),
                    "active": $('#searchActive').val()
                };
            }
        },
        columns: [
            {data: 'guard', name: 'guard'},
            {data: 'name', name: 'name'},
            {data: 'display_name', name: 'display_name'},
            {data: 'active', name: 'active'},
            {data: 'action', name: 'action'}
        ],
        order: [
            [0, 'asc'], [1, 'asc']
        ]
    });
});
</script>
@endpush
