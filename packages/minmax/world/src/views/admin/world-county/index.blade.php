<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('worldCountyCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\World\Admin\WorldCountyPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxWorld::models.WorldCounty.title')</option>
    <option value="code">@lang('MinmaxWorld::models.WorldCounty.code')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('state_id', 'searchState', ['emptyLabel' => __('MinmaxWorld::models.WorldCounty.state_id')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxWorld::models.WorldCounty.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-20">@lang('MinmaxWorld::models.WorldCounty.state_id')</th>
        <th class="w-20">@lang('MinmaxWorld::models.WorldCounty.title')</th>
        <th class="w-20">@lang('MinmaxWorld::models.WorldCounty.code')</th>
        <th>@lang('MinmaxWorld::models.WorldCounty.sort')</th>
        <th>@lang('MinmaxWorld::models.WorldCounty.active')</th>
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
                        "code": searchKeyword
                    };

                    if (searchColumn !== '') {
                        for (var column in d.filter) {
                            if (column !== searchColumn && d.filter.hasOwnProperty(column)) {
                                d.filter[column] = '';
                            }
                        }
                    }

                    d.equal = {
                        "state_id": $('#searchState').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'state_id', name: 'state_id'},
                {data: 'title', name: 'title'},
                {data: 'code', name: 'code'},
                {data: 'sort', name: 'sort'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [0, 'asc'], [3, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush