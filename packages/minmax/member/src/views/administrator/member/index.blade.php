<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
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

@inject('modelPresenter', 'Minmax\Member\Administrator\MemberPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="username">@lang('MinmaxMember::models.Member.username')</option>
    <option value="name">@lang('MinmaxMember::models.Member.name')</option>
    <option value="email">@lang('MinmaxMember::models.Member.email')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('role_id', 'searchRole', ['emptyLabel' => __('MinmaxMember::models.Member.role_id')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxMember::models.Member.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-15">@lang('MinmaxMember::models.Member.username')</th>
        <th class="w-15">@lang('MinmaxMember::models.Member.name')</th>
        <th class="w-20">@lang('MinmaxMember::models.Member.role_id')</th>
        <th>@lang('MinmaxMember::models.Member.active')</th>
        <th>@lang('MinmaxMember::models.Member.created_at')</th>
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
                        "role_id": $('#searchRole').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'username', name: 'username'},
                {data: 'name', name: 'name'},
                {data: 'role_id', name: 'role_id'},
                {data: 'active', name: 'active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [4, 'desc']
            ]
        });
    });
})(jQuery);
</script>
@endpush