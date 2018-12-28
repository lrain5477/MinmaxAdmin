<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links')
    <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::administrator.form.create')">
        <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.create')</span>
    </a>
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Base\Administrator\PermissionPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="group">@lang('MinmaxBase::models.Permission.group')</option>
    <option value="name">@lang('MinmaxBase::models.Permission.name')</option>
    <option value="display_name">@lang('MinmaxBase::models.Permission.display_name')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('guard', 'searchGuard', ['emptyLabel' => __('MinmaxBase::models.Permission.guard')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.Permission.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('MinmaxBase::models.Permission.guard')</th>
        <th class="w-15">@lang('MinmaxBase::models.Permission.group')</th>
        <th class="w-15">@lang('MinmaxBase::models.Permission.name')</th>
        <th class="w-15">@lang('MinmaxBase::models.Permission.display_name')</th>
        <th>@lang('MinmaxBase::models.Permission.sort')</th>
        <th>@lang('MinmaxBase::models.Permission.active')</th>
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
                        "group": searchKeyword,
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
                {data: 'group', name: 'group'},
                {data: 'name', name: 'name'},
                {data: 'display_name', name: 'display_name'},
                {data: 'sort', name: 'sort'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [4, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush