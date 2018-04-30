@extends('administrator.default.view')

@section('action-buttons')
    <div class="float-right">
        <a class="btn btn-sm btn-light" href="{{ route('index', [$pageData->uri]) }}" title="@lang('administrator.form.back_list')">
            <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
        </a>
        <a class="btn btn-sm btn-main" href="{{ route('edit', [$pageData->uri, $formData->guid]) }}" title="@lang('administrator.form.edit')">
            <i class="icon-pencil"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.edit')</span>
        </a>
    </div>
@endsection

@section('views')
    @inject('modelPresenter', 'App\Presenters\Administrator\LanguagePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>主要設定</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'title') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'codes') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'name') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'icon') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>進階選項</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'sort') !!}

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>系統紀錄</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection