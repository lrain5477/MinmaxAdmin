<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
@if($adminData->can('firewallCreate'))
<div class="float-right">
    <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
        <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
    </a>
</div>
@endif
@endsection

@section('grid-filter')
<div class="col-md-auto">
    <div class="dataTablesSearch row no-gutters">
        <label class="col-auto mr-2"><i class="icon-search i-o align-middle h3 mb-0 p-0"></i>@lang('MinmaxBase::admin.grid.search')</label>
        <div class="col col-md-auto mr-1">
            <input class="form-control form-control-sm table-search-input" type="search" placeholder="" aria-controls="tableList" id="sch_keyword" name="sch_keyword"/>
        </div>
    </div>
</div>

<div class="col-md">
    <div class="datatableFilter row no-gutters justify-content-end text-nowrap">
        <label class="col-auto mr-1"><i class="icon-narrow i-o align-middle h3 mb-0 p-0"></i>@lang('MinmaxBase::admin.grid.filter')</label>
        <div class="col col-md-auto ml-1">
            <select class="bs-select form-control sch_select" id="searchRule" name="searchRule" data-style="btn-outline-light btn-sm">
                <option selected="selected" value="">@lang('MinmaxBase::admin.grid.selection.all_rule')</option>
                <option value="1">@lang('MinmaxBase::models.Firewall.selection.rule.1')</option>
                <option value="0">@lang('MinmaxBase::models.Firewall.selection.rule.0')</option>
            </select>
        </div>
        <div class="col col-md-auto ml-1">
            <select class="bs-select form-control sch_select" id="searchActive" name="searchActive" data-style="btn-outline-light btn-sm">
                <option selected="selected" value="">@lang('MinmaxBase::admin.grid.selection.all_active')</option>
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
        <th>@lang('MinmaxBase::models.Firewall.ip')</th>
        <th>@lang('MinmaxBase::models.Firewall.rule')</th>
        <th>@lang('MinmaxBase::models.Firewall.active')</th>
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
                    let searchKeyword = $('#sch_keyword').val();
                    d.filter = {
                        "ip": searchKeyword
                    };
                    d.equal = {
                        "rule": $('#searchRule').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'ip', name: 'ip'},
                {data: 'rule', name: 'rule'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [1, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush