<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.index')

@inject('modelPresenter', 'Minmax\Base\Administrator\LoginLogPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="username">@lang('MinmaxBase::models.LoginLog.username')</option>
    <option value="ip">@lang('MinmaxBase::models.LoginLog.ip')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('guard', 'searchGuard', ['emptyLabel' => __('MinmaxBase::models.LoginLog.guard')]) !!}
    {!! $modelPresenter->getFilterSelection('result', 'searchResult', ['emptyLabel' => __('MinmaxBase::models.LoginLog.result')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('MinmaxBase::models.LoginLog.guard')</th>
        <th class="w-25">@lang('MinmaxBase::models.LoginLog.username')</th>
        <th class="nosort">@lang('MinmaxBase::models.LoginLog.ip')</th>
        <th class="nosort">@lang('MinmaxBase::models.LoginLog.remark')</th>
        <th>@lang('MinmaxBase::models.LoginLog.result')</th>
        <th>@lang('MinmaxBase::models.LoginLog.created_at')</th>
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
                        "ip": searchKeyword
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
                        "result": $('#searchResult').val()
                    };
                }
            },
            columns: [
                {data: 'guard', name: 'guard'},
                {data: 'username', name: 'username'},
                {data: 'ip', name: 'ip'},
                {data: 'remark', name: 'remark'},
                {data: 'result', name: 'result'},
                {data: 'created_at', name: 'created_at'}
            ],
            order: [
                [5, 'desc']
            ]
        });
    });
})(jQuery);
</script>
@endpush