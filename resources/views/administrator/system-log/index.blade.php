@extends('administrator.default.index')

@section('grid-filter')
<div class="col-md-auto">
    <div class="dataTablesSearch row no-gutters">
        <label class="col-auto mr-2"><i class="icon-search i-o align-middle h3 mb-0 p-0"></i>@lang('administrator.grid.search')</label>
        <div class="col col-md-auto mr-1">
            <input class="form-control form-control-sm table-search-input" type="search" placeholder="" aria-controls="tableList" id="sch_keyword" name="sch_keyword"/>
        </div>
    </div>
</div>

<div class="col-md">
    <div class="datatableFilter row no-gutters justify-content-end text-nowrap">
        <label class="col-auto mr-1"><i class="icon-narrow i-o align-middle h3 mb-0 p-0"></i>@lang('administrator.grid.filter')</label>
        <div class="col col-md-auto ml-1">
            <select class="bs-select form-control sch_select" id="searchGuard" name="searchGuard" data-style="btn-outline-light btn-sm">
                <option selected="selected" value="">@lang('administrator.grid.selection.all_guard')</option>
                <option value="administrator">administrator</option>
                <option value="admin">admin</option>
                <option value="merchant">merchant</option>
            </select>
        </div>
        <div class="col col-md-auto ml-1">
            <select class="bs-select form-control sch_select" id="searchResult" name="searchResult" data-style="btn-outline-light btn-sm">
                <option selected="selected" value="">@lang('administrator.grid.selection.all_result')</option>
                <option value="1">@lang('models.SystemLog.selection.result.1')</option>
                <option value="0">@lang('models.SystemLog.selection.result.0')</option>
            </select>
        </div>
    </div>
</div>
@endsection

@section('grid-table')
<input type="hidden" id="model"  value="{{ $pageData->model }}">

<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('models.SystemLog.guard')</th>
        <th>@lang('models.SystemLog.uri')</th>
        <th>@lang('models.SystemLog.action')</th>
        <th>@lang('models.SystemLog.result')</th>
        <th>@lang('models.SystemLog.username')</th>
        <th>@lang('models.SystemLog.created_at')</th>
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
            url: '/admin/js/lang/{{ app()->getLocale() }}/datatables.json'
        },
        ajax: {
            url: '{{ route('datatables', ['uri' => $pageData->uri]) }}',
            data: function (d) {
                let searchKeyword = $('#sch_keyword').val();
                d.filter = {
                    "uri": searchKeyword,
                    "action": searchKeyword,
                    "username": searchKeyword,
                    "guard": $('#searchGuard').val(),
                    "result": $('#searchResult').val()
                };
            }
        },
        columns: [
            {data: 'guard', name: 'guard'},
            {data: 'uri', name: 'uri'},
            {data: 'action', name: 'action'},
            {data: 'result', name: 'result'},
            {data: 'username', name: 'username'},
            {data: 'created_at', name: 'created_at'}
        ],
        order: [
            [5, 'desc']
        ]
    });
});
</script>
@endpush