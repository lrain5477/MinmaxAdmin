<?php
/**
 * @var \Minmax\Base\Models\AdministratorMenu $pageData
 */
?>

@extends('MinmaxBase::administrator.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::administrator.layouts.right-links')
        @if(!is_null($parentModel))
        <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index", ['parent' => $parentModel->parent_id]) }}" title="@lang('MinmaxBase::administrator.grid.back')">
            <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.grid.back')</span>
        </a>
        @endif
        <a class="btn btn-sm btn-main" href="{{ langRoute("administrator.{$pageData->uri}.create", ['parent' => request('parent')]) }}" title="@lang('MinmaxBase::administrator.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::administrator.form.create')</span>
        </a>
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Base\Administrator\WebMenuPresenter')

@section('grid-filter')
    @component('MinmaxBase::administrator.layouts.grid.filter-keyword')
    <option value="title">@lang('MinmaxBase::models.WebMenu.title')</option>
    @endcomponent

    @component('MinmaxBase::administrator.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('editable', 'searchEditable', ['emptyLabel' => __('MinmaxBase::models.WebMenu.editable')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.WebMenu.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
{!! Breadcrumbs::view('MinmaxBase::admin.layouts.table-breadcrumbs', 'datatable') !!}
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-50">@lang('MinmaxBase::models.WebMenu.title')</th>
        <th>@lang('MinmaxBase::models.WebMenu.sort')</th>
        <th>@lang('MinmaxBase::models.WebMenu.editable')</th>
        <th>@lang('MinmaxBase::models.WebMenu.active')</th>
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
                url: '{{ langRoute("administrator.{$pageData->uri}.ajaxDataTable", ['parent' => request('parent')]) }}',
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
                        "editable": $('#searchEditable').val(),
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'title', name: 'title'},
                {data: 'sort', name: 'sort'},
                {data: 'editable', name: 'editable'},
                {data: 'active', name: 'active'},
                {data: 'action', name: 'action'}
            ],
            order: [
                [1, 'asc']
            ]
        });
    });
})(jQuery);
</script>
@endpush