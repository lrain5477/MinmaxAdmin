@extends('admin.default.index')

@section('action-buttons')
@if($adminData->can('adminCreate'))
<div class="float-right">
    <a class="btn btn-sm btn-main" href="{{ route('admin.create', [$pageData->uri]) }}" title="@lang('admin.form.create')">
        <i class="icon-plus2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.create')</span>
    </a>
</div>
@endif
@endsection

@section('grid-filter')
<div class="col-md-auto">
    <div class="dataTablesSearch row no-gutters">
        <label class="col-auto mr-2"><i class="icon-search i-o align-middle h3 mb-0 p-0"></i>@lang('admin.grid.search')</label>
        <div class="col col-md-auto mr-1">
            <input class="form-control form-control-sm table-search-input" type="search" placeholder="" aria-controls="tableList" id="sch_keyword" name="sch_keyword"/>
        </div>
    </div>
</div>

<div class="col-md">
    <div class="datatableFilter row no-gutters justify-content-end text-nowrap">
        <label class="col-auto mr-1"><i class="icon-narrow i-o align-middle h3 mb-0 p-0"></i>@lang('admin.grid.filter')</label>
        <div class="col col-md-auto ml-1">
            <select class="bs-select form-control sch_select" id="searchActive" name="searchActive" data-style="btn-outline-light btn-sm">
                <option selected="selected" value="">@lang('admin.grid.selection.all_active')</option>
                <option value="1">@lang('models.Admin.selection.active.1')</option>
                <option value="0">@lang('models.Admin.selection.active.0')</option>
            </select>
        </div>
    </div>
</div>
@endsection

@section('grid-table')
<input type="hidden" id="model"  value="{{ $pageData->model }}">

<table class="table table-responsive-md table-bordered table-striped table-hover table-checkable datatables" id="tableList">
    <thead>
    <tr role="row">
        <th>@lang('models.Admin.username')</th>
        <th>@lang('models.Admin.name')</th>
        <th>@lang('models.Admin.email')</th>
        <th class="nosort">@lang('models.Admin.role_id')</th>
        <th>@lang('models.Admin.active')</th>
        <th class="nosort">@lang('admin.grid.title.action')</th>
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
                url: '/admin/js/lang/{{ app()->getLocale() }}/datatables.json'
            },
            ajax: {
                url: '{{ route('admin.datatables', ['uri' => $pageData->uri]) }}',
                data: function (d) {
                    let searchKeyword = $('#sch_keyword').val();
                    d.filter = {
                        "username": searchKeyword,
                        "name": searchKeyword,
                        "email": searchKeyword
                    };
                    d.equal = {
                        "active": $('#searchActive').val()
                    };
                }
            },
            columns: [
                {data: 'username', name: 'username'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role_id', name: 'role_id'},
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