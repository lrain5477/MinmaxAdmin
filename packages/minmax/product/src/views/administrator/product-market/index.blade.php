<?php
/**
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

@inject('modelPresenter', 'Minmax\Product\Administrator\ProductMarketPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxProduct::models.ProductMarket.title')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxProduct::models.ProductMarket.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-10">@lang('MinmaxProduct::models.ProductMarket.code')</th>
        <th class="w-25">@lang('MinmaxProduct::models.ProductMarket.title')</th>
        <th class="w-15">@lang('MinmaxProduct::models.ProductMarket.admin_id')</th>
        <th>@lang('MinmaxProduct::models.ProductMarket.sort')</th>
        <th>@lang('MinmaxProduct::models.ProductMarket.active')</th>
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
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'code', name: 'code'},
                {data: 'title', name: 'title'},
                {data: 'admin_id', name: 'admin_id'},
                {data: 'sort', name: 'sort'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [3, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush