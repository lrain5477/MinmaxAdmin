<?php
/**
 * @var \App\Models\WebData $formData
 */
?>

@extends('admin.default.edit')

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Admin\WebDataPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.default')</legend>

        {!! $modelPresenter->getFieldText($formData, 'website_name', ['required' => true]) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'system_email', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'system_url', ['required' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.information')</legend>

        {!! $modelPresenter->getFieldText($formData, 'company', ['required' => true, 'subColumn' => 'name']) !!}

        {!! $modelPresenter->getFieldTel($formData, 'contact', ['required' => true, 'subColumn' => 'phone']) !!}

        {!! $modelPresenter->getFieldTel($formData, 'contact', ['subColumn' => 'fax']) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'contact', ['required' => true, 'subColumn' => 'email']) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'address']) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'lng', 'size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'lat', 'size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'contact', ['subColumn' => 'map', 'size' => 2]) !!}

        {!! $modelPresenter->getFieldText($formData, 'social', ['subColumn' => 'facebook', 'icon' => 'icon-facebook3']) !!}

        {!! $modelPresenter->getFieldText($formData, 'social', ['subColumn' => 'youtube', 'icon' => 'icon-youtube2']) !!}

    </fieldset>

    <fieldset class="mt-4" id="advFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_description', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_keywords', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'google_analytics') !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'offline_text', ['hint' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('admin.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('admin.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection