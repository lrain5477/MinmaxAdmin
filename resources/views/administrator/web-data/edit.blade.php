@extends('administrator.default.edit')

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\WebDataPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'website_name', true) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'system_email', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'system_url', true) !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.information')</legend>

        {!! $modelPresenter->getFieldText($formData, 'company_name', true) !!}

        {!! $modelPresenter->getFieldTel($formData, 'phone', true) !!}

        {!! $modelPresenter->getFieldTel($formData, 'fax') !!}

        {!! $modelPresenter->getFieldEmail($formData, 'email', true) !!}

        {!! $modelPresenter->getFieldText($formData, 'address') !!}

        {!! $modelPresenter->getFieldText($formData, 'map_lng', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'map_lat', ['size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'map_url') !!}

        {!! $modelPresenter->getFieldText($formData, 'link_facebook', ['icon' => 'icon-facebook3']) !!}

        {!! $modelPresenter->getFieldText($formData, 'link_youtube', ['icon' => 'icon-youtube2']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldTextarea($formData, 'seo_description', ['hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'seo_keywords', ['hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'google_analytics') !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', true, ['inline' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'offline_text', ['hint' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')">
    </div>
@endsection