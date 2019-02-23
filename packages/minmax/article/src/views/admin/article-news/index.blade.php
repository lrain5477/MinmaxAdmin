<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 * @var \Minmax\Article\Models\ArticleCategory $parentModel
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('articleNewsCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create", ['parent' => request('parent')]) }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
        @slot('batchActions')
            @if($adminData->can('articleNewsEdit'))
            <button class="dropdown-item" type="button" onclick="multiSwitch('{{ langRoute("admin.{$pageData->uri}.ajaxMultiSwitch") }}', 'active', 1)"><i class="icon-eye mr-2 text-muted"></i>啟用</button>
            <button class="dropdown-item" type="button" onclick="multiSwitch('{{ langRoute("admin.{$pageData->uri}.ajaxMultiSwitch") }}', 'active', 0)"><i class="icon-cancel mr-2 text-muted"></i>停用</button>
            @endif
            @if($adminData->can('articleNewsDestroy'))
            <button class="dropdown-item" type="button" onclick="multiDelete('{{ langRoute("admin.{$pageData->uri}.ajaxMultiDestroy") }}')"><i class="icon-trashcan mr-2 text-muted"></i>刪除</button>
            @endif
        @endslot
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Article\Admin\ArticleNewsPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxArticle::models.ArticleNews.title')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('categories', 'searchCategory', ['emptyLabel' => __('MinmaxArticle::models.ArticleNews.categories')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxArticle::models.ArticleNews.active')]) !!}
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
        <th class="w-5 nosort">@lang('MinmaxArticle::models.ArticleNews.pic')</th>
        <th class="w-50">@lang('MinmaxArticle::models.ArticleNews.title')</th>
        <th class="nosort">@lang('MinmaxArticle::models.ArticleNews.count')</th>
        <th>@lang('MinmaxArticle::models.ArticleNews.start_at')</th>
        <th>@lang('MinmaxArticle::models.ArticleNews.active')</th>
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
                url: '{{ langRoute("admin.{$pageData->uri}.ajaxDataTable", ['parent' => request('parent')]) }}',
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
                        "category": $('#searchCategory').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'pic', name: 'pic'},
                {data: 'top', name: 'top'},
                {data: 'count', name: 'count'},
                {data: 'start_at', name: 'start_at'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [2, 'desc'], [4, 'desc']
            ]
        });
    });
})(jQuery);
</script>
@endpush