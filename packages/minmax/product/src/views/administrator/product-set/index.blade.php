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
        @isset($importLink)
        <a class="btn btn-sm btn-main" href="{{ $importLink }}" title="@lang('MinmaxBase::administrator.form.import')">
            <i class="icon-upload2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.import')</span>
        </a>
        @endisset
        @isset($exportLink)
        <a class="btn btn-sm btn-main" href="{{ $exportLink }}" title="@lang('MinmaxBase::administrator.form.export')">
            <i class="icon-download"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.export')</span>
        </a>
        @endisset
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Product\Administrator\ProductSetPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxProduct::models.ProductSet.title')</option>
    <option value="sku">@lang('MinmaxProduct::models.ProductSet.sku')</option>
    <option value="serial">@lang('MinmaxProduct::models.ProductSet.serial')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('categories', 'searchCategory', ['current' => request('category'), 'emptyLabel' => __('MinmaxProduct::models.ProductSet.categories')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxProduct::models.ProductSet.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="nosort w-5">@lang('MinmaxProduct::models.ProductSet.pic')</th>
        <th class="nosort">@lang('MinmaxProduct::models.ProductSet.title')</th>
        <th class="nosort w-5">@lang('MinmaxProduct::models.ProductSet.price')</th>
        <th class="nosort w-5">@lang('MinmaxProduct::admin.grid.ProductSet.relation')</th>
        <th class="w-5">@lang('MinmaxProduct::models.ProductSet.updated_at')</th>
        <th class="w-5">@lang('MinmaxProduct::models.ProductSet.sort')</th>
        <th class="w-5">@lang('MinmaxProduct::models.ProductSet.active')</th>
        <th class="nosort w-10">@lang('MinmaxBase::administrator.grid.title.action')</th>
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
                url: '{{ langRoute("administrator.{$pageData->uri}.ajaxDataTable", ['item' => request('item'), 'spec' => request('spec')]) }}',
                data: function (d) {
                    var searchKeyword = $('#sch_keyword').val();
                    var searchColumn = $('#sch_column').val();

                    d.filter = {
                        "title": searchKeyword,
                        "sku": searchKeyword,
                        "serial": searchKeyword
                    };

                    if (searchColumn !== '') {
                        for (var column in d.filter) {
                            if (column !== searchColumn && d.filter.hasOwnProperty(column)) {
                                d.filter[column] = '';
                            }
                        }
                    }

                    d.equal = {
                        "category": $('#searchCategory').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'pic', name: 'pic'},
                {data: 'title', name: 'title'},
                {data: 'price', name: 'price', className: 'text-right text-nowrap'},
                {data: 'relation', name: 'relation'},
                {data: 'updated_at', name: 'updated_at', className: 'text-nowrap'},
                {data: 'sort', name: 'sort'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [5, 'asc'], [4, 'desc']
            ]
        });
    });
})(jQuery);
</script>
@endpush