<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('productBrandCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Product\Admin\ProductBrandPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxProduct::models.ProductBrand.title')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxProduct::models.ProductBrand.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="nosort w-5">@lang('MinmaxProduct::models.ProductBrand.pic')</th>
        <th class="w-50">@lang('MinmaxProduct::models.ProductBrand.title')</th>
        <th>@lang('MinmaxProduct::models.ProductBrand.sort')</th>
        <th>@lang('MinmaxProduct::models.ProductBrand.active')</th>
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
                {data: 'pic', name: 'pic'},
                {data: 'title', name: 'title'},
                {data: 'sort', name: 'sort'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [2, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush