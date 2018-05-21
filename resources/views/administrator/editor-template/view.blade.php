@extends('administrator.default.view')

@section('action-buttons')
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ route('administrator.index', [$pageData->uri]) }}" title="@lang('administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
    </a>
    <a class="btn btn-sm btn-main" href="{{ route('administrator.edit', [$pageData->uri, $formData->guid]) }}" title="@lang('administrator.form.edit')">
        <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.edit')</span>
    </a>
</div>
@endsection

@section('views')
    @inject('modelPresenter', 'App\Presenters\Administrator\EditorTemplatePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'guard') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'category') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'description') !!}

        {!! $modelPresenter->getViewEditor($formData, 'editor') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'sort') !!}

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection