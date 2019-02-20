<?php
/**
 * @var \Minmax\Base\Models\Administrator $adminData
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links')
    <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.create", ['category' => request('category')]) }}" title="@lang('MinmaxBase::administrator.form.create')">
        <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.create')</span>
    </a>
    @slot('batchActions')
        <button class="dropdown-item" type="button" onclick="multiSwitch('{{ langRoute("admin.{$pageData->uri}.ajaxMultiSwitch") }}', 'active', 1)"><i class="icon-eye mr-2 text-muted"></i>啟用</button>
        <button class="dropdown-item" type="button" onclick="multiSwitch('{{ langRoute("admin.{$pageData->uri}.ajaxMultiSwitch") }}', 'active', 0)"><i class="icon-cancel mr-2 text-muted"></i>停用</button>
        <button class="dropdown-item" type="button" onclick="multiDelete('{{ langRoute("admin.{$pageData->uri}.ajaxMultiDestroy") }}')"><i class="icon-trashcan mr-2 text-muted"></i>刪除</button>
    @endslot
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Ad\Administrator\AdvertisingPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxAd::models.Advertising.title')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('category_id', 'searchCategory', ['current' => intval(request('category')), 'emptyLabel' => __('MinmaxAd::models.Advertising.category_id')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxAd::models.Advertising.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="nosort w-3">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input group-checkable" type="checkbox" aria-label="Select" data-set="#tableList .checkboxes input" id="checkAll" />
                <label class="custom-control-label" for="checkAll"></label>
            </div>
        </th>
        <th class="w-50">@lang('MinmaxAd::models.Advertising.title')</th>
        <th>@lang('MinmaxAd::models.Advertising.count')</th>
        <th>@lang('MinmaxAd::models.Advertising.sort')</th>
        <th>@lang('MinmaxAd::models.Advertising.start_at')</th>
        <th>@lang('MinmaxAd::models.Advertising.active')</th>
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
                        "category_id": $('#searchCategory').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'category_id', name: 'category_id'},
                {data: 'count', name: 'count'},
                {data: 'sort', name: 'sort'},
                {data: 'start_at', name: 'start_at'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [1, 'asc'], [3, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush