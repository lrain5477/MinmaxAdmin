<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('adminCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Base\Admin\AdminPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="username">@lang('MinmaxBase::models.Admin.username')</option>
    <option value="name">@lang('MinmaxBase::models.Admin.name')</option>
    <option value="email">@lang('MinmaxBase::models.Admin.email')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.Admin.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('MinmaxBase::models.Admin.username')</th>
        <th>@lang('MinmaxBase::models.Admin.name')</th>
        <th>@lang('MinmaxBase::models.Admin.email')</th>
        <th class="nosort">@lang('MinmaxBase::models.Admin.role_id')</th>
        <th>@lang('MinmaxBase::models.Admin.active')</th>
        <th class="nosort">@lang('MinmaxBase::admin.grid.title.action')</th>
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
                url: '{{ langRoute("admin.{$pageData->uri}.ajaxDataTable") }}',
                data: function (d) {
                    var searchKeyword = $('#sch_keyword').val();
                    var searchColumn = $('#sch_column').val();

                    d.filter = {
                        "username": searchKeyword,
                        "name": searchKeyword,
                        "email": searchKeyword
                    };

                    if (searchColumn !== '') {
                        for (var column in d.filter) {
                            if (column !== searchColumn && d.filter.hasOwnProperty(column)) {
                                d.filter[column] = '';
                            }
                        }
                    }

                    d.equal = {
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'username', name: 'username'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role_id', name: 'role_id'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [0, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush