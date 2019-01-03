<?php
/**
 * List page of model NewsletterSchedule
 *
 * @var \App\Models\Admin $adminData
 * @var \App\Models\AdminMenu $pageData
 */
?>

@extends('admin.default.index')

@section('action-buttons')
@if($adminData->can('newsletterScheduleCreate'))
<div class="float-right">
    <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('admin.form.create')">
        <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.create')</span>
    </a>
</div>
@endif
@endsection

@section('grid-filter')
<div class="col-md-auto">
    <div class="dataTablesSearch row no-gutters">
        <label class="col-auto mr-2"><i class="icon-search i-o align-middle h3 mb-0 p-0"></i>@lang('admin.grid.search')</label>
        <div class="col col-md-auto mr-1">
            <input class="form-control form-control-sm table-search-input" type="search" placeholder="" aria-controls="tableList" id="sch_keyword" name="sch_keyword"/>
        </div>
    </div>
</div>
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('models.NewsletterSchedule.title')</th>
        <th class="w-50">@lang('models.NewsletterSchedule.subject')</th>
        <th>@lang('models.NewsletterSchedule.schedule_at')</th>
        <th class="nosort">@lang('admin.grid.title.action')</th>
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
                        "title": searchKeyword,
                        "subject": searchKeyword
                    };
                }
            },
            columns: [
                {data: 'title', name: 'title'},
                {data: 'subject', name: 'subject'},
                {data: 'schedule_at', name: 'schedule_at'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [2, 'desc']
            ]
        });
    });
})(jQuery);
</script>
@endpush