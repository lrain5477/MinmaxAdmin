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

@inject('modelPresenter', 'Minmax\World\Administrator\WorldCountryPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxWorld::models.WorldCountry.title')</option>
    <option value="code">@lang('MinmaxWorld::models.WorldCountry.code')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('continent_id', 'searchContinent', ['emptyLabel' => __('MinmaxWorld::models.WorldCountry.continent_id')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxWorld::models.WorldCountry.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-20">@lang('MinmaxWorld::models.WorldCountry.continent_id')</th>
        <th class="w-20">@lang('MinmaxWorld::models.WorldCountry.title')</th>
        <th class="w-20">@lang('MinmaxWorld::models.WorldCountry.code')</th>
        <th>@lang('MinmaxWorld::models.WorldCountry.sort')</th>
        <th>@lang('MinmaxWorld::models.WorldCountry.active')</th>
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
                        "continent_id": $('#searchContinent').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'continent_id', name: 'continent_id'},
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