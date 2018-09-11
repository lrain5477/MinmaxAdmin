<?php
/**
 * @var \App\Models\Admin $adminData
 * @var \App\Models\AdminMenu $pageData
 */
?>

@extends('admin.default.index')

@section('grid-filter')
<div class="col-md-auto">
    <div class="dataTablesSearch row no-gutters">
        <label class="col-auto mr-2"><i class="icon-search i-o align-middle h3 mb-0 p-0"></i>@lang('admin.grid.search')</label>
        <div class="col col-md-auto mr-1">
            <input class="form-control form-control-sm table-search-input" type="search" placeholder="網址、管理員、IP" aria-controls="tableList" id="sch_keyword" name="sch_keyword"/>
        </div>
    </div>
</div>

<div class="col-md">
    <div class="datatableFilter row no-gutters justify-content-end text-nowrap">
        <label class="col-auto mr-1"><i class="icon-narrow i-o align-middle h3 mb-0 p-0"></i>@lang('admin.grid.filter')</label>
        <div class="col col-md-auto ml-1">
            <select class="bs-select form-control sch_select" id="searchResult" name="searchResult" data-style="btn-outline-light btn-sm">
                <option selected="selected" value="">@lang('admin.grid.selection.all_result')</option>
                <option value="1">成功</option>
                <option value="0">失敗</option>
            </select>
        </div>
    </div>
</div>
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="nosort">操作網址</th>
        <th>項目ID</th>
        <th>管理員</th>
        <th class="nosort">IP</th>
        <th class="nosort">說明</th>
        <th>狀態</th>
        <th>時間戳</th>
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
                url: '/admin/js/lang/{{ app()->getLocale() }}/datatables.json'
            },
            ajax: {
                url: '{{ langRoute("admin.{$pageData->uri}.ajaxDataTable") }}',
                data: function (d) {
                    let searchKeyword = $('#sch_keyword').val();
                    d.filter = {
                        "uri": searchKeyword,
                        "username": searchKeyword,
                        "ip": searchKeyword
                    };
                    d.equal = {
                        "result": $('#searchResult').val(),
                    };
                }
            },
            columns: [
                {data: 'uri', name: 'uri'},
                {data: 'guid', name: 'guid'},
                {data: 'username', name: 'username'},
                {data: 'ip', name: 'ip'},
                {data: 'remark', name: 'remark'},
                {data: 'result', name: 'result', render: function(data) { return data === '1' ? '成功' : '失敗'; }},
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