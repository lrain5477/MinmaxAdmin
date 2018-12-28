<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@inject('modelPresenter', 'Minmax\Base\Admin\SystemLogPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="uri">@lang('MinmaxBase::models.SystemLog.uri')</option>
    <option value="username">@lang('MinmaxBase::models.SystemLog.username')</option>
    <option value="ip">@lang('MinmaxBase::models.SystemLog.ip')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('result', 'searchResult', ['emptyLabel' => __('MinmaxBase::models.SystemLog.result')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="nosort">@lang('MinmaxBase::models.SystemLog.uri')</th>
        <th>@lang('MinmaxBase::models.SystemLog.id')</th>
        <th>@lang('MinmaxBase::models.SystemLog.username')</th>
        <th class="nosort">@lang('MinmaxBase::models.SystemLog.ip')</th>
        <th class="nosort">@lang('MinmaxBase::models.SystemLog.remark')</th>
        <th>@lang('MinmaxBase::models.SystemLog.result')</th>
        <th>@lang('MinmaxBase::models.SystemLog.created_at')</th>
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
                        "uri": searchKeyword,
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
                        "result": $('#searchResult').val()
                    };
                }
            },
            columns: [
                {data: 'uri', name: 'uri'},
                {data: 'id', name: 'id'},
                {data: 'username', name: 'username'},
                {data: 'ip', name: 'ip'},
                {data: 'remark', name: 'remark'},
                {data: 'result', name: 'result'},
                {data: 'created_at', name: 'created_at'}
            ],
            order: [
                [6, 'desc']
            ]
        });
    });
})(jQuery);
</script>
@endpush