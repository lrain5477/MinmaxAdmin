<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.index')

@inject('modelPresenter', 'Minmax\Base\Administrator\WebDataPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="website_name">@lang('MinmaxBase::models.WebData.website_name')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('guard', 'searchGuard', ['emptyLabel' => __('MinmaxBase::models.WebData.guard')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.WebData.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('MinmaxBase::models.WebData.guard')</th>
        <th class="w-50">@lang('MinmaxBase::models.WebData.website_name')</th>
        <th>@lang('MinmaxBase::models.WebData.system_email')</th>
        <th>@lang('MinmaxBase::models.WebData.active')</th>
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
                        "website_name": searchKeyword
                    };

                    if (searchColumn !== '') {
                        for (var column in d.filter) {
                            if (column !== searchColumn && d.filter.hasOwnProperty(column)) {
                                d.filter[column] = '';
                            }
                        }
                    }

                    d.equal = {
                        "rule": $('#searchRule').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'guard', name: 'guard'},
                {data: 'website_name', name: 'website_name'},
                {data: 'system_email', name: 'system_email'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [3, 'desc']
            ]
        });
    });
})(jQuery);
</script>
@endpush