<?php
/**
 * @var \App\Models\AdministratorMenu $pageData
 * @var \App\Models\WebData $formData
 */
?>

@extends('administrator.default.edit')

@section('action-buttons')
<div class="float-right">
    <a class="btn btn-sm btn-light" href="{{ langRoute("administrator.{$pageData->uri}.index") }}" title="@lang('administrator.form.back_list')">
        <i class="icon-undo2"></i><span class="ml-1 d-none d-md-inline-block">@lang('administrator.form.back_list')</span>
    </a>
</div>
@endsection

@section('forms')
    @inject('modelPresenter', 'App\Presenters\Administrator\WebDataPresenter')

    <fieldset id="baseFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.default')</legend>

        {!! $modelPresenter->getViewNormalText($formData, 'guard') !!}

        {!! $modelPresenter->getFieldText($formData, 'website_name', ['required' => true]) !!}

        {!! $modelPresenter->getFieldEmail($formData, 'system_email', ['required' => true]) !!}

        {!! $modelPresenter->getFieldText($formData, 'system_url', ['required' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="mediaFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.media')</legend>

        {!! $modelPresenter->getFieldMediaImage($formData, 'system_logo', ['required' => true, 'limit' => 1, 'hint' => true]) !!}

    </fieldset>

    <fieldset class="mt-4" id="infoFieldSet">
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.information')</legend>

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
        <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('administrator.form.fieldSet.advanced')</legend>

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_description', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'seo', ['subColumn' => 'meta_keywords', 'hint' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'google_analytics') !!}

        {!! $modelPresenter->getFieldRadio($formData, 'active', ['required' => true, 'inline' => true]) !!}

        {!! $modelPresenter->getFieldTextarea($formData, 'offline_text', ['hint' => true]) !!}

    </fieldset>

    <div class="text-center my-4 form-btn-group">
        <input class="btn btn-main" type="submit" id="submitBut" value="@lang('administrator.form.button.send')">
        <input class="btn btn-default" type="reset" value="@lang('administrator.form.button.reset')" onclick="window.location.reload(true)">
    </div>
@endsection