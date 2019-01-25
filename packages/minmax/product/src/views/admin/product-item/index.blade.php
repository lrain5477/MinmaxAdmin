<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('productItemCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Product\Admin\ProductItemPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxProduct::models.ProductItem.title')</option>
    <option value="sku">@lang('MinmaxProduct::models.ProductItem.sku')</option>
    <option value="serial">@lang('MinmaxProduct::models.ProductItem.serial')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxProduct::models.ProductItem.active')]) !!}
    {!! $modelPresenter->getFilterStatusTag('searchTag', ['emptyLabel' => __('MinmaxProduct::admin.grid.ProductItem.tags.title')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="nosort w-5">@lang('MinmaxProduct::models.ProductItem.pic')</th>
        <th class="nosort w-50">@lang('MinmaxProduct::models.ProductItem.title')</th>
        <th class="nosort">@lang('MinmaxProduct::models.ProductItem.qty')</th>
        <th>@lang('MinmaxProduct::models.ProductItem.active')</th>
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
                        "active": $('#searchActive').val(),
                        "status_tag": $('#searchTag').val()
                    };
                }
            },
            columns: [
                {data: 'pic', name: 'pic'},
                {data: 'title', name: 'title'},
                {data: 'qty', name: 'qty'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ]
        });
    });
})(jQuery);
</script>
@endpush