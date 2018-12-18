<?php
/**
 * @var \Illuminate\Database\Eloquent\Collection|\Minmax\Base\Models\WorldLanguage[] $languageActive
 * @var \Minmax\Base\Models\WebData $formData
 */
?>

@extends('MinmaxBase::admin.layouts.page.edit', ['formDataId' => $formData->id])

@section('action-buttons')
    @component('MinmaxBase::admin.layouts.right-links', ['languageActive' => $languageActive])
    @endcomponent
@endsection

@section('forms')
    @inject('modelPresenter', 'Minmax\Base\Admin\WebDataPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'website_name', ['required' => true]) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'system_email', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'system_url', ['required' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="mediaFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.media')</legend>

        {!! $modelPresenter->getFieldMediaImage($formData, 'system_logo', ['required' => true, 'limit' => 1, 'hint' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.information')</legend>

        {!! $modelPresenter->getFieldText($formData, 'company', ['required' => true, 'subColumn' => 'name']) !!}

        {!! $modelPresenter->getFieldTel($formData, 'contact', ['required' => true, 'subColumn' => 'phone']) !!}

        {!! $modelPresenter->getFieldTel($formData, 'contact', ['subColumn' => 'fax']) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'contact', ['required' => true, 'subColumn' => 'email']) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'address']) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'lng', 'size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'lat', 'size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'map', 'size' => 10]) !!}

        {!! $modelPresenter->getFieldText($formData, 'social', ['subColumn' => 'facebook', 'icon' => 'icon-facebook3']) !!}

        {!! $modelPresenter->getFieldText($formData, 'social', ['subColumn' => 'instagram', 'icon' => 'icon-instagram2']) !!}

        {!! $modelPresenter->getFieldText($formData, 'social', ['subColumn' => 'youtube', 'icon' => 'icon-youtube2']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('MinmaxBase::admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_description', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_keywords', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'options', ['subColumn' => 'head', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'options', ['subColumn' => 'body', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'options', ['subColumn' => 'foot', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'offline_text', ['hint' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('MinmaxBase::admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('MinmaxBase::admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection