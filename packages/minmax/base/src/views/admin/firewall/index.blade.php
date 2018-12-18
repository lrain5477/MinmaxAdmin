<?php
/**
 * @var \Minmax\Base\Models\Admin $adminData
 * @var \Minmax\Base\Models\AdminMenu $pageData
 */
?>

@extends('MinmaxBase::admin.layouts.page.index')

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links')
        @if($adminData->can('firewallCreate'))
        <a class="btn btn-sm btn-main" href="{{ langRoute("admin.{$pageData->uri}.create") }}" title="@lang('MinmaxBase::admin.form.create')">
            <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('MinmaxBase::admin.form.create')</span>
        </a>
        @endif
    @endcomponent
@endsection

@inject('modelPresenter', 'Minmax\Base\Admin\FirewallPresenter')

@section('grid-filter')
    @component('MinmaxBase::admin.layouts.grid.filter-keyword')
    <option value="ip">@lang('MinmaxBase::models.Firewall.ip')</option>
    @endcomponent

    @component('MinmaxBase::admin.layouts.grid.filter-equal')
    {!! $modelPresenter->getFilterSelection('rule', 'searchRule', ['emptyLabel' => __('MinmaxBase::models.Firewall.rule')]) !!}
    {!! $modelPresenter->getFilterSelection('active', 'searchActive', ['emptyLabel' => __('MinmaxBase::models.Firewall.active')]) !!}
    @endcomponent
@endsection

@section('grid-table')
<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th class="w-50">@lang('MinmaxBase::models.Firewall.ip')</th>
        <th>@lang('MinmaxBase::models.Firewall.rule')</th>
        <th>@lang('MinmaxBase::models.Firewall.active')</th>
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
                        "ip": searchKeyword
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
                {data: 'ip', name: 'ip'},
                {data: 'rule', name: 'rule'},
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