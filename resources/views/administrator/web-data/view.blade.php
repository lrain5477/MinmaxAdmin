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
    @inject('modelPresenter', 'App\Presenters\Administrator\RolePresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'website_name') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'system_email') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'system_url') !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.information')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'company_name') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'phone') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'fax') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'email') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'address') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'map_lng') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'map_lat') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'map_url') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'link_facebook') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'link_youtube') !!}

    </fieldset>

    <fieldset class="mt-4" id="seoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.seo')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'seo_description') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'seo_keywords') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'google_analytics', $formData->google_analytics == '' ? '' : '(Hide)') !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getViewSelection($formData, 'active') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'offline_text') !!}

    </fieldset>

    <fieldset class="mt-4" id="sysFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.system_record')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'created_at') !!}

        {!! $modelPresenter->getViewNormalText($formData, 'updated_at') !!}

    </fieldset>

@endsection