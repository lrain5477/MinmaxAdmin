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

@inject('modelPresenter', 'Minmax\Base\Administrator\EditorTemplatePresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="category">@lang('MinmaxBase::models.EditorTemplate.category')</option>
    <option value="title">@lang('MinmaxBase::models.EditorTemplate.title')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('guard', 'searchGuard', ['emptyLabel' => __('MinmaxBase::models.EditorTemplate.guard')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.EditorTemplate.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-20">@lang('MinmaxBase::models.EditorTemplate.guard')</th>
        <th class="w-20">@lang('MinmaxBase::models.EditorTemplate.category')</th>
        <th class="w-20">@lang('MinmaxBase::models.EditorTemplate.title')</th>
        <th>@lang('MinmaxBase::models.EditorTemplate.sort')</th>
        <th>@lang('MinmaxBase::models.EditorTemplate.active')</th>
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
                        "category": searchKeyword,
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
                        "guard": $('#searchRule').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'guard', name: 'guard'},
                {data: 'category', name: 'category'},
                {data: 'title', name: 'title'},
                {data: 'sort', name: 'sort'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [1, 'asc'], [0, 'asc'], [3, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush