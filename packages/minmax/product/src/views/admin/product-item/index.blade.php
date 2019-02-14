<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var string $importLink
 * @var string $exportLink
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
        @if(!is_null($importLink) && $adminData->can('ioDataImport'))
        <a class="btn btn-sm btn-main" href="{{ $importLink }}" title="@lang('MinmaxBase::admin.form.import')">
            <i class="icon-upload2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.import')</span>
        </a>
        @endif
        @if(!is_null($exportLink) && $adminData->can('ioDataExport'))
        <a class="btn btn-sm btn-main" href="{{ $exportLink }}" title="@lang('MinmaxBase::admin.form.export')">
            <i class="icon-download"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.export')</span>
        </a>
        @endif
        @if($adminData->can('productItemEdit'))
        <button id="update-qty" class="btn btn-sm btn-secondary" type="button" title="@lang('MinmaxProduct::admin.form.update_qty')">
            <i class="icon-loop2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxProduct::admin.form.update_qty')</span>
        </button>
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
        <th class="nosort">@lang('MinmaxProduct::models.ProductItem.title')</th>
        <th class="nosort w-5">@lang('MinmaxProduct::models.ProductItem.qty')</th>
        <th class="nosort w-5">@lang('MinmaxProduct::admin.grid.ProductItem.relation')</th>
        <th class="w-5">@lang('MinmaxProduct::models.ProductItem.updated_at')</th>
        <th class="w-5">@lang('MinmaxProduct::models.ProductItem.active')</th>
        <th class="nosort w-10">@lang('MinmaxBase::admin.grid.title.action')</th>
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
                url: '{{ langRoute("admin.{$pageData->uri}.ajaxDataTable", ['set' => request('set')]) }}',
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
                {data: 'qty', name: 'qty', className: 'text-center'},
                {data: 'relation', name: 'relation'},
                {data: 'updated_at', name: 'updated_at', className: 'text-nowrap'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [4, 'desc']
            ]
        });

        $('#update-qty').on('click', function () {
            var updateSet = {};
            $('#tableList .inputQty').each(function () {
                var $this = $(this);
                if (parseInt($this.val()) !== parseInt($this.attr('data-qty'))) {
                    updateSet[$this.attr('data-id')] = $this.val();
                }
            });

            if (Object.keys(updateSet).length > 0) {
                $.ajax({
                    url: '{{ langRoute('admin.product-item.ajaxMultiQty') }}',
                    data: {data: updateSet},
                    type: 'PUT', dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function () {
                        $('#tableList').DataTable().draw(false);
                        swal("@lang('MinmaxProduct::admin.form.ProductItem.messages.qty_success_title')", "@lang('MinmaxProduct::admin.form.ProductItem.messages.qty_success_text')", "success");
                    },
                    error: function () {
                        swal("@lang('MinmaxProduct::admin.form.ProductItem.messages.qty_nothing_title')", "@lang('MinmaxProduct::admin.form.ProductItem.messages.qty_nothing_text')");
                    }
                });
            } else {
                swal("@lang('MinmaxProduct::admin.form.ProductItem.messages.qty_nothing_title')", "@lang('MinmaxProduct::admin.form.ProductItem.messages.qty_nothing_text')");
            }
        });
    });
})(jQuery);
</script>
@endpush