@extends('admin.default.view')

@section('action-buttons')
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ route('admin.index', [$pageData->uri]) }}" title="@lang('admin.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.back_list')</span>
    </a>
    @if($adminData->can('adminEdit'))
    <a class="btn btn-sm btn-main" href="{{ route('admin.edit', [$pageData->uri, $formData->guid]) }}" title="@lang('admin.form.edit')">
        <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('admin.form.edit')</span>
    </a>
    @endif
</div>
@endsection

@section('views')
    @inject('modelPresenter', 'App\Presenters\Admin\AdminPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>主要設定</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'role_id', $formData->roles()->first()->display_name) !!}

        {!! $modelPresenter->getViewNormalText($formData, 'username') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'name') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'email') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>進階選項</legend>

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>系統紀錄</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection