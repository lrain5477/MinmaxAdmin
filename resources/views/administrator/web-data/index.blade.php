<?php
/**
 * @var \App\Models\AdministratorMenu $pageData
 */
?>

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
            <select class="bs-select form-control sch_select" id="searchActive" name="searchActive" data-style="btn-outline-light btn-sm">
                <option selected="selected" value="">@lang('administrator.grid.selection.all_active')</option>
                <option value="1">{{ systemParam('active.1.title') }}</option>
                <option value="0">{{ systemParam('active.0.title') }}</option>
            </select>
        </div>
    </div>
</div>
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-25">@lang('models.WebData.guard')</th>
        <th class="w-25">@lang('models.WebData.website_name')</th>
        <th class="w-25">@lang('models.WebData.system_email')</th>
        <th>@lang('models.WebData.active')</th>
        <th class="nosort">@lang('administrator.grid.title.action')</th>
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
            url: '{{ langRoute("administrator.{$pageData->uri}.ajaxDataTable") }}',
            data: function (d) {
                let searchKeyword = $('#sch_keyword').val();
                d.filter = {
                    "guard": searchKeyword,
                    "website_name": searchKeyword,
                    "system_email": searchKeyword
                };
                d.equal = {
                    "active": $('#searchActive').val()
                };
            }
        },
        columns: [
            {data: 'guard', name: 'guard'},
            {data: 'website_name', name: 'website_name'},
            {data: 'system_email', name: 'system_email'},
            {data: 'active', name: 'active'},
            {data: 'action', name: 'action'}
        ],
        order: [
            [3, 'asc'], [0, 'asc']
        ]
    });
});
</script>
@endpush