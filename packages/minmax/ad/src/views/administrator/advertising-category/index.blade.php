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

@inject('modelPresenter', 'Minmax\Ad\Administrator\AdvertisingCategoryPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="code">@lang('MinmaxAd::models.AdvertisingCategory.code')</option>
    <option value="title">@lang('MinmaxAd::models.AdvertisingCategory.title')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('ad_type', 'searchType', ['emptyLabel' => __('MinmaxAd::models.AdvertisingCategory.ad_type')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxAd::models.AdvertisingCategory.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-15">@lang('MinmaxAd::models.AdvertisingCategory.code')</th>
        <th class="w-25">@lang('MinmaxAd::models.AdvertisingCategory.title')</th>
        <th class="w-15">@lang('MinmaxAd::models.AdvertisingCategory.ad_type')</th>
        <th class="nosort">@lang('MinmaxAd::models.AdvertisingCategory.amount')</th>
        <th>@lang('MinmaxAd::models.AdvertisingCategory.sort')</th>
        <th>@lang('MinmaxAd::models.AdvertisingCategory.active')</th>
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
                        "code": searchKeyword,
                        "title": searchKeyword
                    };

                    if (searchColumn !== '') {
                        for (var column in d.filter) {
                            if (column !== searchColumn && d.filter.hasOwnProperty(column)) {
                                d.filter[column] = '';
                            }
                        }
                    }

                    d.equal = {
                        "ad_type": $('#searchType').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'code', name: 'code'},
                {data: 'title', name: 'title'},
                {data: 'ad_type', name: 'ad_type'},
                {data: 'amount', name: 'amount'},
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