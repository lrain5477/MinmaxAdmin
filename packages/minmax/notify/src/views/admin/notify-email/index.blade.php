<?php
/**
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Notify\Admin\NotifyEmailPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxNotify::models.NotifyEmail.title')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxNotify::models.NotifyEmail.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-5">No.</th>
        <th class="w-75">@lang('MinmaxNotify::models.NotifyEmail.title')</th>
        <th>@lang('MinmaxNotify::models.NotifyEmail.active')</th>
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
                {data: 'sort', name: 'sort'},
                {data: 'title', name: 'title'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [0, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush